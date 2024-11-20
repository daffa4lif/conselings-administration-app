<?php

namespace Database\Factories\Conseling;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conseling\Conseling>
 */
class ConselingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $decission = fake()->boolean();

        return [
            'student_id' => \App\Models\Master\Student::inRandomOrder()->first()->id,
            'case' => fake()->paragraph(1),
            'status' => $decission ? 'FINISH' : 'PROCESS',
            'solution' => $decission ? fake()->paragraph() : null,
            'user_id' => \App\Models\User::inRandomOrder()->first()->id
        ];
    }
}
