<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // High User System
        User::create([
            'name' => 'Super Admin BK',
            'email' => 'super@gmail.com',
            'password' => 'password'
        ]);

        $this->call(StudentSeeder::class);
    }
}
