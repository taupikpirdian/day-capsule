<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserAdminSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(InstitutionCategorySeeder::class);
        $this->call(InstitutionCategoryPartSeeder::class);
        $this->call(JenisPerkaraSeeder::class);
        $this->call(PekerjaanSeeder::class);
        $this->call(RolePermissionSeeder::class);
    }
}
