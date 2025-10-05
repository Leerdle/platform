<?php

namespace App\Actions\Exercise;

use App\Models\Exercise;
use Illuminate\Support\Facades\DB;

final class CreateExercise
{
    /**
     * @param  array<mixed>  $attributes
     * @return mixed
     */
    public function handle(array $attributes): Exercise
    {
        return DB::transaction(function () use ($attributes) {
            return Exercise::query()
                ->create($attributes);
        });
    }
}
