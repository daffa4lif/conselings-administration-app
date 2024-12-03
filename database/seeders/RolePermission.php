<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // super sensitive
            "crud user staff",
            "list user staff",
            "crud user student",
            "list user student",

            // common
            "list reports",

            "list conseling",
            "crud conseling",

            "list cases",
            "crud cases",

            "list absent",
            "crud absent",

            "list classroom",
            "crud classroom",

            "list student",
            "crud student",

            "list home visit",
            "crud home visit",
        ];

        $roles = [
            "super admin",
            "kepala sekolah",
            "guru kelas",
            "guru bk"
        ];

        foreach ($permissions as $item) {
            Permission::create(['name' => $item]);
        }

        foreach ($roles as $item) {
            Role::create(['name' => $item]);
        }

        // kepala sekolah as review all only
        Role::where('name', "kepala sekolah")->first()->givePermissionTo([
            "list reports",
            "list conseling",
            "list cases",
            "list absent",
            "list classroom",
            "list student",
            "list home visit",
        ]);
        // guru kelas as review class and student only
        Role::where('name', "guru kelas")->first()->givePermissionTo([
            "list absent",
            "list classroom",
            "list student",
        ]);
        // bk all
        Role::where('name', "guru bk")->first()->givePermissionTo([
            "list reports",

            "list conseling",
            "crud conseling",

            "list cases",
            "crud cases",

            "list absent",
            "crud absent",

            "list classroom",
            "crud classroom",

            "list student",
            "crud student",

            "list home visit",
            "crud home visit",
        ]);
    }
}
