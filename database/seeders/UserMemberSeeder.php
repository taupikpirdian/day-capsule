<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed Users with Roles
        $admin = User::updateOrCreate(
            [
                'email' => 'pirdiantaupik@gmail.com',
            ],
            [
                'name' => 'Taupik Pirdian',
                'password' => bcrypt('p@ssword'),
            ]
        );
        $admin->assignRole(ROLE_MEMBER);
    }
}
