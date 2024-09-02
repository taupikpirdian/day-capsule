<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Seeder role permission seeder dimulai ... ');

        // Admin
        $permissionsAll = Permission::get()->pluck('name');
        $roleAdmin = Role::where('name', ROLE_ADMIN)->first();
        $roleAdmin->syncPermissions($permissionsAll);

        $this->command->info('Seeder roles seeder selesai ... ');
    }
}
