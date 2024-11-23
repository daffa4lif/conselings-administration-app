<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(UserSeeder::class);

        if (\Illuminate\Support\Facades\App::isLocal()) {
            $this->call(StudentSeeder::class);
            $this->call(ClassroomSeeder::class);
            $this->call(StudentsClassroomSeeder::class);
            $this->call(HomeVisitSeeder::class);
            $this->call(ConselingSeeder::class);
            $this->call(ConselingGroupSeeder::class);
        }
    }
}
