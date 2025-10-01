<?php

declare(strict_types=1);

use App\Models\Exercise;
use App\Models\Question;

test('to array', function () {
    $exercise = Exercise::factory()->create()->refresh();

    expect(array_keys($exercise->toArray()))
        ->toBe([
            'id',
            'date',
            'title',
            'language_code',
            'subject',
            'type',
            'metadata',
            'created_at',
            'updated_at',
        ]);
});

test('relation questions', function () {
    $exercise = Exercise::factory()->hasQuestions(3)->create()->refresh();

    expect($exercise->questions)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(Question::class);
});
