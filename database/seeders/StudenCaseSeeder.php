<?php

namespace Database\Seeders;

use App\Models\StudenCase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudenCaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StudenCase::factory(100)->create();

        $date = now()->subYear()->startOfYear()->addDays(rand(0, 364));
        StudenCase::factory(100)->create([
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        $date = now()->subYears(2)->startOfYear()->addDays(rand(0, 364));
        StudenCase::factory(100)->create([
            'created_at' => $date,
            'updated_at' => $date,
        ]);
    }
}
