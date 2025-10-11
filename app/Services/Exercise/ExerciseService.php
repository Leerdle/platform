<?php

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

    public function __construct()
    {
        $this->apiService = new ApiService();
        $this->messageContent = "Give me 10 challenging sentences in Dutch using the imperfect tense at C1 language level. The statements should be challenging and realistic using good grammar and interesting vocabulary. Include at least 2 questions. Include at least 1 sentence where 2 imperfect tense verbs are used. Use a mix of regular and irregular verbs. Make sure all verbs are unique in the exercise. Include both singular and plural forms. The imperfect verb in each sentence should be replaced with <mask> and the answer should be provided separately. I expect the response back in JSON format such as the following: [{'question': 'Ik <mask> naar de supermarkt.', 'answer': ['ging'], 'infinitive': ['gaan']}, {'question': 'Waar <mask> jullie gisteren avond?', 'answer': ['waren'], 'infinitive': ['zijn']}, {'question': 'Ik <mask> thuis en <mask> een koffie.', 'answer': ['bleef', 'dronk'], 'infinitive': ['blijven', 'drinken']}]";
        $this->exerciseTitle = "Nederlandstalige Oefening - Imperfectum";
        $this->exerciseDescription = "Je ziet 10 zinnen. Maak de zinnen af met het imperfectum van het verbum tussen haakjes.";
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
            "temperature" => 0.8,
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
