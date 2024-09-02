<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Seeder permission seeder dimulai ... ');
        $datas = [
            [
                "name" => 'user-list',
            ],
            [
                "name" => 'user-create',
            ],
            [
                "name" => 'user-update',
            ],
            [
                "name" => 'user-delete',
            ],
            [
                "name" => 'activity-list',
            ],
            [
                "name" => 'activity-create',
            ],
            [
                "name" => 'activity-update',
            ],
            [
                "name" => 'activity-delete',
            ]
        ];
        foreach ($datas as $data){
            Permission::updateOrCreate(['name' => $data["name"]]);
        }
        $this->command->info('Proses seeder selesai. Terimakasih DevOps...');

    }
}
