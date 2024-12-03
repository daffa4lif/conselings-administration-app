<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // High User System
        User::create([
            'name' => 'Super Admin BK',
            'email' => 'super@gmail.com',
            'password' => 'password'
        ])->assignRole("super admin");

        User::create([
            'name' => 'nama kepala sekolah',
            'email' => 'kapsek@example.com',
            'password' => 'password'
        ])->assignRole("kepala sekolah");

        User::create([
            'name' => 'nama guru kelas',
            'email' => 'guru@example.com',
            'password' => 'password'
        ])->assignRole("guru kelas");

        User::create([
            'name' => 'nama guru bk',
            'email' => 'guru-bk@example.com',
            'password' => 'password'
        ])->assignRole("guru bk");
    }
}
