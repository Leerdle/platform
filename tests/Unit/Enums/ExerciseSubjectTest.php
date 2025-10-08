<?php

declare(strict_types = 1);

use App\Enums\ExerciseSubject;

it('has correct values', function() {
    expect(ExerciseSubject::IMPERFECT_TENSE->value)->toBe(1);
});

it('can get correct keys', function() {
    expect(ExerciseSubject::from(1))->toBe(ExerciseSubject::IMPERFECT_TENSE);
});
