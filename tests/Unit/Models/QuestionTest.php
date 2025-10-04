<?php

declare(strict_types=1);

use App\Models\Exercise;
use App\Models\Question;

test('to array', function () {
    $question = Question::factory()->create()->refresh();

    expect(array_keys($question->toArray()))
        ->toBe([
            'id',
            'exercise_id',
            'text',
            'answer',
            'metadata',
            'created_at',
            'updated_at',
        ]);
});

test('relation exercise', function () {
    $question = Question::factory()->create()->refresh();

    expect($question->exercise)
        ->toBeInstanceOf(Exercise::class)
        ->and($question->exercise_id)->toBe($question->exercise->id);
});
