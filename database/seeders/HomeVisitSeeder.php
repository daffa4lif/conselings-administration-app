<?php

namespace Database\Seeders;

use App\Models\HomeVisit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomeVisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HomeVisit::factory(20)->create();

        for ($i = 0; $i < 30; $i++) {
            $date = now()->subYear()->startOfYear()->addDays(rand(0, 364));
            HomeVisit::factory(rand(10, 20))->create([
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            $date = now()->subYears(2)->startOfYear()->addDays(rand(0, 364));
            HomeVisit::factory(rand(5, 15))->create([
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}
