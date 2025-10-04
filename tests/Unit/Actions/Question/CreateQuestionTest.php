<?php

declare(strict_types=1);

use App\Actions\Question\CreateQuestion;
use App\Models\Exercise;
use App\Models\Question;

it('may create a question', function () {
    $exercise = Exercise::factory()->create();
    $action = new CreateQuestion;

    $question = $action->handle([
        'exercise_id' => $exercise->id,
        'text' => 'Question Text',
        'answer' => 'Answer Text',
        'metadata' => null,
    ]);

    expect($question)->toBeInstanceOf(Question::class)
        ->and($question->text)->toBe('Question Text')
        ->and($question->answer)->toBe('Answer Text');

    $this->assertDatabaseHas('questions', [
        'text' => 'Question Title',
    ]);
});
