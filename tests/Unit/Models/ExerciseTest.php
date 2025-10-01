<?php

declare(strict_types=1);

use App\Models\Exercise;

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
