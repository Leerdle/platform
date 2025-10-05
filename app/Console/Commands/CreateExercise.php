<?php

namespace App\Console\Commands;

use App\Actions\Question\CreateQuestion;
use App\Services\Exercise\ExerciseService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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

    public function handle(ExerciseService $exerciseService, CreateExercise $createExercise, CreateQuestion $createQuestion): void
    {
        try {
            $response = $exerciseService->get();
            $data = $exerciseService->process($response);

            DB::transaction(function () use ($exerciseService, $createExercise, $createQuestion, $data) {
                $validatedExercise = $exerciseService->validateExercise();
                $exercise = $createExercise->handle($validatedExercise);

                foreach ($data as $question) {
                    $validatedQuestion = $exerciseService->validateQuestion($data, $exercise->id);
                    $createQuestion->handle($validatedQuestion);
                }
            });
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
