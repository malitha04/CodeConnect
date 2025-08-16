<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create the 'Client', 'Developer', and 'Admin' roles if they don't exist
        $clientRole = Role::firstOrCreate(['name' => 'Client']);
        $developerRole = Role::firstOrCreate(['name' => 'Developer']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // You can also add permissions here and sync them to roles
        // For now, we'll just focus on creating the roles
    }
}
