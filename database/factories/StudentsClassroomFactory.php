<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentsClassroom>
 */
class StudentsClassroomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => \App\Models\Master\Student::factory(),
            'classroom_id' => \App\Models\Master\Classroom::inRandomOrder()->first()->id,
            'year' => fake()->randomElement([2012, 2013, 2014, 2015, 2016, 2017])
        ];
    }
}
