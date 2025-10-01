<?php

namespace Database\Factories;

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
            'order' => $this->faker->numberBetween(1, 5),
            'text' => $this->faker->words(4, true),
            'answer' => $this->faker->word(),
            'metadata' => null
        ];
    }
}
