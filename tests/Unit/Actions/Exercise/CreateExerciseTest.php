<?php

declare(strict_types=1);

use App\Actions\Exercise\CreateExercise;
use App\Enums\ExerciseLanguageCode;
use App\Enums\ExerciseSubject;
use App\Enums\ExerciseType;
use App\Models\Exercise;

it('may create an exercise', function () {
    $action = new CreateExercise;

    $exercise = $action->handle([
        'date' => '2025-10-02',
        'title' => 'Exercise Title',
        'description' => 'Exercise Description',
        'language_code' => ExerciseLanguageCode::NL,
        'subject' => ExerciseSubject::IMPERFECT_TENSE,
        'type' => ExerciseType::GAP_ATTACK,
        'metadata' => null,
    ]);

    expect($exercise)->toBeInstanceOf(Exercise::class)
        ->and($exercise->title)->toBe('Exercise Title')
        ->and($exercise->language_code)->toBe(ExerciseLanguageCode::NL);

    $this->assertDatabaseHas('exercises', [
        'title' => 'Exercise Title',
    ]);
});
