<?php

declare(strict_types=1);

use App\Models\Question;

test('to array', function () {
    $question = Question::factory()->create()->refresh();

    expect(array_keys($question->toArray()))
        ->toBe([
            'id',
            'exercise_id',
            'order',
            'text',
            'answer',
            'metadata',
            'created_at',
            'updated_at',
        ]);
});
