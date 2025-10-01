<?php

namespace Database\Factories;

use App\Enums\ExerciseLanguageCode;
use App\Enums\ExerciseSubject;
use App\Enums\ExerciseType;
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
            'language_code' => $this->faker->randomElement(ExerciseLanguageCode::cases()),
            'subject' => $this->faker->randomElement(ExerciseSubject::cases()),
            'type' => $this->faker->randomElement(ExerciseType::cases()),
            'metadata' => null
        ];
    }
}
