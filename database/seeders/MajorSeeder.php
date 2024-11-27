<?php

namespace Database\Seeders;

use App\Models\Master\Major;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'IPA',
            'IPS'
        ];

        foreach ($data as $key => $value) {
            Major::create(['name' => $value]);
        }
    }
}
