<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the three roles required for the application
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Client']);
        Role::create(['name' => 'Developer']);
    }
}
