<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Absent>
 */
class AbsentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => \App\Models\Master\Student::inRandomOrder()->first()->id,
            'violation_date' => fake()->dateTimeBetween('-3 years'),
            'type' => fake()->randomElement(['IZIN', 'ALPHA', 'SAKIT']),
            'description' => fake()->paragraph(1),
            'user_id' => \App\Models\User::inRandomOrder()->first()->id
        ];
    }
}
