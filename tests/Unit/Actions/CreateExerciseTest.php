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
        'title' => 'Dutch Imperfect Tense Practice',
        'language_code' => ExerciseLanguageCode::NL,
        'subject' => ExerciseSubject::IMPERFECT_TENSE,
        'type' => ExerciseType::FILL_IN_THE_BLANKS,
        'metadata' => null,
    ]);

    expect($exercise)->toBeInstanceOf(Exercise::class)
        ->and($exercise->title)->toBe('Dutch Imperfect Tense Practice')
        ->and($exercise->language_code)->toBe(ExerciseLanguageCode::NL);

    $this->assertDatabaseHas('exercises', [
        'title' => 'Dutch Imperfect Tense Practice',
    ]);
});
