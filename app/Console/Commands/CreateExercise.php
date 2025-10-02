<?php

namespace App\Console\Commands;

use App\Actions\Exercise\CreateExercise as CreateExerciseAction;
use App\Enums\ExerciseLanguageCode;
use App\Enums\ExerciseSubject;
use App\Enums\ExerciseType;
use App\Http\Requests\Exercise\StoreExerciseRequest;
use App\Models\Exercise;
use App\Models\Question;
use App\Services\HuggingFaceApi;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CreateExercise extends Command
{
    /**
     * @var string
     */
    protected $signature = 'create:exercise';

    /**
     * @var string
     */
    protected $description = 'Command description';

    public function handle(HuggingFaceApi $huggingFaceApi, CreateExerciseAction $createExercise): void
    {
        try {
            $response = $huggingFaceApi->createExercise();
            $data = json_decode($response->getContent(), true);

            $contentJson = $data['choices'][0]['message']['content'];

            $contentJson = trim($contentJson);
            $contentJson = preg_replace('/^```json\s*/', '', $contentJson);
            $contentJson = preg_replace('/\s*```$/', '', $contentJson);

            $questions = json_decode($contentJson, true);

            $latestExercise = Exercise::query()
                ->orderBy('date', 'desc')
                ->first();

            $nextDate = $latestExercise ? Carbon::parse($latestExercise->date)->addDay() : Carbon::today();

            $exerciseData = [
                'date' => $nextDate->toDateString(),
                'title' => 'Dutch Imperfect Tense Practice',
                'language_code' => ExerciseLanguageCode::NL->value,
                'subject' => ExerciseSubject::IMPERFECT_TENSE->value,
                'type' => ExerciseType::FILL_IN_THE_BLANKS->value,
                'metadata' => null,
            ];

            $validator = Validator::make($exerciseData, (new StoreExerciseRequest)->rules());

            if ($validator->fails()) {
                $this->error('Validation failed: ' . $validator->errors()->first());
                return;
            }

            $exercise = $createExercise->handle($validator->validated());

            // TODO foreach() argument must be of type array|object, null given
            foreach ($questions as $index => $question) {
                Question::create([
                    'exercise_id' => $exercise->id,
                    'order' => $index + 1,
                    'text' => Str::trim($question['question']),
                    'answer' => Str::trim($question['answer']),
                    'metadata' => [
                        'infinitive' => Str::trim($question['infinitive']),
                    ],
                ]);
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
