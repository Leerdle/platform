<?php

declare(strict_types = 1);

use App\Enums\ExerciseLanguageCode;

it('has correct values', function() {
    expect(ExerciseLanguageCode::NL->value)->toBe(1);
});

it('can get correct keys', function() {
    expect(ExerciseLanguageCode::from(1))->toBe(ExerciseLanguageCode::NL);
});
