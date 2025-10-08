<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\Question;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        foreach(range(1, 5) as $index) {
            $exercise = Exercise::factory()->create();

            Question::factory(10)
                ->create([
                    'exercise_id' => $exercise->id,
                ]);
        }
    }
}
