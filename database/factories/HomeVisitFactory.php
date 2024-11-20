<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HomeVisit>
 */
class HomeVisitFactory extends Factory
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
            'parent_name' => fake()->name(),
            'case' => fake()->paragraph(1),
            'status' => $decission ? 'FINISH' : 'PROCESS',
            'solution' => $decission ? fake()->paragraph() : null
        ];
    }
}
