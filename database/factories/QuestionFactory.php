<?php

namespace Database\Factories;

use App\Models\Exercise;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'exercise_id' => Exercise::factory(),
            'text' => $this->faker->words(4, true),
            'answer' => $this->faker->word(),
            'metadata' => [
                'infinitive' => $this->faker->word(),
            ]
        ];
    }
}
