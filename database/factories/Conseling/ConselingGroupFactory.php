<?php

namespace Database\Factories\Conseling;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conseling\ConselingGroup>
 */
class ConselingGroupFactory extends Factory
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
            'category' => fake()->randomElement(["AKADEMIK", "NON-AKADEMIK", "KEDISIPLINAN"]),
            'case' => fake()->paragraph(1),
            'status' => $decission ? 'FINISH' : 'PROCESS',
            'solution' => $decission ? fake()->paragraph() : null,
            'user_id' => \App\Models\User::inRandomOrder()->first()->id
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (\App\Models\Conseling\ConselingGroup $conselingGroup) {
            for ($i = 1; $i < rand(1, 10); $i++) {
                \App\Models\Conseling\ConselingStudents::create([
                    'conseling_group_id' => $conselingGroup->id,
                    'student_id' => \App\Models\Master\Student::inRandomOrder()->first()->id
                ]);
            }
        });
    }
}
