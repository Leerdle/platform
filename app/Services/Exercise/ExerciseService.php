<?php

declare(strict_types=1);

namespace App\Services\Exercise;

use App\Http\Requests\Question\StoreQuestionRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Enums\ExerciseLanguageCode;
use App\Enums\ExerciseSubject;
use App\Enums\ExerciseType;
use App\Http\Requests\Exercise\StoreExerciseRequest;
use App\Models\Exercise;
use App\Services\HuggingFace\ApiService;
use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use RuntimeException;

final readonly class ExerciseService
{
    /**
     * @var ApiService $apiService
     * @var string $messageContent
     * @var string $exerciseTitle
     * @var string $exerciseDescription
     */
    private ApiService $apiService;
    private string $messageContent;
    private string $exerciseTitle;
    private string $exerciseDescription;

    public function __construct(
        private string $language,
        private string $type,
        private string $subject,
        private TemplateService $templateService
    )
    {
        $this->apiService = new ApiService();

        $template = $this->templateService->getExerciseTemplate($this->language, $this->type, $this->subject);

        $this->messageContent = $template['message'] ?? '';
        $this->exerciseTitle = $template['title'] ?? '';
        $this->exerciseDescription = $template['description'] ?? '';
    }

    /**
     * Other models tried:
     * Qwen/Qwen2.5-7B-Instruct:together
     *
     * @return JsonResponse
     * @throws ConnectionException
     */
    public function get(): JsonResponse
    {
        Log::info('Starting API call to generate exercise');

        $response = $this->apiService->apiCall([
            "messages" => [
                [
                    "role" => "user",
                    "content" => $this->messageContent,
                ]
            ],
            "model" => "CohereLabs/command-a-reasoning-08-2025:cohere",
            "stream" => false,
            "temperature" => 0.95,
            "seed" => rand(1, 1000000)
        ]);

        Log::info('API call completed', [
            'response' => $response->json(),
            'status' => $response->status()
        ]);

        return response()->json($response->json(), $response->status());
    }

    /**
     * @param JsonResponse $data
     * @return array
     */
    public function process(JsonResponse $data): array
    {
        Log::info('Processing API response');

        $response = json_decode($data->getContent(), true);

        if (!isset($response['choices'][0]['message']['content'])) {
            Log::error('Invalid API response structure', ['response' => $response]);
            throw new RuntimeException('Invalid API response structure');
        }

        $contentJson = $response['choices'][0]['message']['content'];
        Log::debug('Raw content extracted', ['content' => $contentJson]);

        if (preg_match('/```(?:json)?\s*(\[.*?])\s*```/s', $contentJson, $matches)) {
            $contentJson = $matches[1];
        } else {
            $contentJson = trim($contentJson);
            $contentJson = preg_replace('/^```(?:json)?\s*/m', '', $contentJson);
            $contentJson = preg_replace('/```.*$/s', '', $contentJson);
            $contentJson = trim($contentJson);
        }

        Log::debug('Cleaned JSON content', ['content' => $contentJson]);

        $exercises = json_decode($contentJson, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Failed to parse exercise JSON', [
                'error' => json_last_error_msg(),
                'content' => $contentJson
            ]);

            throw new RuntimeException('Failed to parse exercise JSON: ' . json_last_error_msg());
        }

        if (!is_array($exercises)) {
            Log::error('Invalid exercises format', ['type' => gettype($exercises)]);
            throw new RuntimeException('Expected array of exercises, got: ' . gettype($exercises));
        }

        Log::info('Successfully processed exercises', ['count' => count($exercises)]);

        return $exercises;
    }

    /**
     * @return array
     * @throws ValidationException
     */
    public function validateExercise(): array
    {
        Log::info('Validating exercise data');

        $latestExercise = Exercise::query()
            ->orderBy('date', 'desc')
            ->first();

        $nextDate = $latestExercise ? Carbon::parse($latestExercise->date)->addDay() : Carbon::today();

        $exerciseData = [
            'date' => $nextDate->toDateString(),
            'title' => $this->exerciseTitle,
            'description' => $this->exerciseDescription,
            'language_code' => ExerciseLanguageCode::NL->value,
            'subject' => ExerciseSubject::IMPERFECT_TENSE->value,
            'type' => ExerciseType::GAP_ATTACK->value,
            'metadata' => null,
        ];

        Log::debug('Exercise data prepared', ['data' => $exerciseData]);

        $validator = Validator::make($exerciseData, (new StoreExerciseRequest)->rules());

        if ($validator->fails())
        {
            Log::error('Exercise validation failed', ['errors' => $validator->errors()->toArray()]);
            throw new ValidationException($validator);
        }

        Log::info('Exercise validation passed');

        return $validator->validated();
    }

    /**
     * @param array $data
     * @param int $exerciseId
     * @return array
     * @throws ValidationException
     */
    public function validateQuestion(array $data, int $exerciseId): array
    {
        Log::debug('Validating question', ['raw_data' => $data, 'exercise_id' => $exerciseId]);

        $questionData = [
            'exercise_id' => $exerciseId,
            'text' => Str::trim($data['question']),
            'answer' => array_map('trim', $data['answer']),
            'metadata' => [
                'infinitive' => array_map('trim', $data['infinitive']),
            ],
        ];

        $validator = Validator::make($questionData, (new StoreQuestionRequest)->rules());

        if ($validator->fails())
        {
            Log::error('Question validation failed', [
                'errors' => $validator->errors()->toArray(),
                'data' => $questionData
            ]);

            throw new ValidationException($validator);
        }

        Log::debug('Question validation passed');

        return $validator->validated();
    }
}
