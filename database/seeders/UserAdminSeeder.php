<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Role Admin
        Role::updateOrCreate(['name' => 'admin']);

        // Seed Users with Roles
        $admin = User::updateOrCreate(
            [
                'email' => 'admin@mail.com',
            ],
            [
                'name' => 'Admin',
                'password' => bcrypt('p@ssword'),
            ]
        );
        $admin->assignRole('admin');

    }
}
