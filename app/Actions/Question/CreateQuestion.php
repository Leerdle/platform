<?php

namespace App\Actions\Question;

use App\Models\Question;
use Illuminate\Support\Facades\DB;

final class CreateQuestion
{
    /**
     * @param  array<mixed>  $attributes
     * @return Question
     */
    public function handle(array $attributes): Question
    {
        return DB::transaction(function () use ($attributes) {
            return Question::query()
                ->create($attributes);
        });
    }
}
