<?php

declare(strict_types = 1);

use App\Enums\ExerciseType;

it('has correct values', function() {
    expect(ExerciseType::FILL_IN_THE_BLANKS->value)->toBe(1);
});

it('can get correct keys', function() {
    expect(ExerciseType::from(1))->toBe(ExerciseType::FILL_IN_THE_BLANKS);
});
