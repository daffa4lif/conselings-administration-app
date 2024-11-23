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
    }
}
