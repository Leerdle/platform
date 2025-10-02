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
    public function handle(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {
            return Exercise::create($attributes);
        });
    }
}
