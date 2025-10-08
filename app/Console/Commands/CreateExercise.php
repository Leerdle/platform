<?php

namespace App\Console\Commands;

use App\Actions\Question\CreateQuestion;
use App\Actions\Exercise\CreateExercise as CreateExerciseAction;
use App\Services\Exercise\ExerciseService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function handle(ExerciseService $exerciseService, CreateExerciseAction $createExerciseAction, CreateQuestion $createQuestion): void
    {
        try {
            Log::info('Starting exercise creation command');

            $response = $exerciseService->get();
            $data = $exerciseService->process($response);

            Log::info('Beginning database transaction');

            DB::transaction(function () use ($exerciseService, $createExerciseAction, $createQuestion, $data) {
                $validatedExercise = $exerciseService->validateExercise();

                Log::info('Creating exercise');
                $exercise = $createExerciseAction->handle($validatedExercise);
                Log::info('Exercise created', ['exercise_id' => $exercise->id]);

                Log::info('Creating questions', ['count' => count($data)]);
                foreach ($data as $index => $question) {
                    $validatedQuestion = $exerciseService->validateQuestion($question, $exercise->id);
                    $createdQuestion = $createQuestion->handle($validatedQuestion);
                    Log::debug('Question created', ['question_id' => $createdQuestion->id, 'index' => $index]);
                }
            });

            Log::info('Exercise creation completed successfully');
            $this->info('Exercise created successfully');
        } catch (Exception $e) {
            Log::error('Exercise creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->error($e->getMessage());
        }
    }
}
