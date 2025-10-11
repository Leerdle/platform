<?php

declare(strict_types = 1);

use App\Enums\ExerciseType;

it('has correct values', function() {
    expect(ExerciseType::GAP_ATTACK->value)->toBe(1);
});

it('can get correct keys', function() {
    expect(ExerciseType::from(1))->toBe(ExerciseType::GAP_ATTACK);
});
