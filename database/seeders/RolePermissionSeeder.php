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

        // Kejari
        $permissionKejari = [
            'lapdu-list',
            'lapdu-create',
            'lapdu-update',
            'lapdu-delete',
            'penyelidikan-list',
            'penyelidikan-create',
            'penyelidikan-update',
            'penyelidikan-delete',
            'penyidikan-list',
            'penyidikan-create',
            'penyidikan-update',
            'penyidikan-delete',
            'tuntutan-list',
            'tuntutan-create',
            'tuntutan-update',
            'tuntutan-delete',
            'eksekusi-list',
            'eksekusi-create',
            'eksekusi-update',
            'eksekusi-delete'
        ];
        $roleKejari = Role::where('name', ROLE_KEJARI)->first();
        $roleKejari->syncPermissions($permissionKejari);

        // Kejati
        $permissionKejarti = [
            'lapdu-list',
            'lapdu-create',
            'lapdu-update',
            'lapdu-delete',
            'penyelidikan-list',
            'penyelidikan-create',
            'penyelidikan-update',
            'penyelidikan-delete',
            'penyidikan-list',
            'penyidikan-create',
            'penyidikan-update',
            'penyidikan-delete',
            'tuntutan-list',
            'eksekusi-list',
        ];
        $roleKejati = Role::where('name', ROLE_KEJATI)->first();
        $roleKejati->syncPermissions($permissionKejarti);

        $this->command->info('Seeder roles seeder selesai ... ');
    }
}
