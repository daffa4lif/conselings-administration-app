<?php

namespace Database\Seeders;

use App\Models\Conseling\Conseling;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConselingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Conseling::factory(200)->create();

        $date = now()->subYear()->startOfYear()->addDays(rand(0, 364));
        Conseling::factory(100)->create([
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        $date = now()->subYears(2)->startOfYear()->addDays(rand(0, 364));
        Conseling::factory(100)->create([
            'created_at' => $date,
            'updated_at' => $date,
        ]);
    }
}
