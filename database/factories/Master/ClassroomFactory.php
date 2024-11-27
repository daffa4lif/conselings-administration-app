<?php

namespace Database\Factories\Master;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Master\Classroom>
 */
class ClassroomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $romanNumerals = ['X', 'XI', 'XII'];
        $alphabets     = range('A', 'Z');

        // Generate random index
        $romanIndex    = $this->faker->numberBetween(0, count($romanNumerals) - 1);
        $alphabetIndex = $this->faker->numberBetween(0, count($alphabets) - 1);

        // Combine Roman numeral and alphabet
        $name = $romanNumerals[$romanIndex] . ' ' . $alphabets[$alphabetIndex];

        return [
            'name' => $name,
            'major' => \App\Models\Master\Major::inRandomOrder()->first()->name,
        ];
    }
}
