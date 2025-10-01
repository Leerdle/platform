<?php

namespace Database\Factories;

use App\Models\Exercise;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Exercise>
 */
class ExerciseFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => Carbon::now()->toDateString(),
            'title' => $this->faker->sentence(),
            'language_code' => 'NL',
            'subject' => 'Imperfect',
            'type' => 'fillinblanks',
            'metadata' => null
        ];
    }
}
