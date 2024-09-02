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
                "name" => 'lapdu-list',
            ],
            [
                "name" => 'lapdu-create',
            ],
            [
                "name" => 'lapdu-update',
            ],
            [
                "name" => 'lapdu-delete',
            ],
            [
                "name" => 'penyelidikan-list',
            ],
            [
                "name" => 'penyelidikan-create',
            ],
            [
                "name" => 'penyelidikan-update',
            ],
            [
                "name" => 'penyelidikan-delete',
            ],
            [
                "name" => 'penyidikan-list',
            ],
            [
                "name" => 'penyidikan-create',
            ],
            [
                "name" => 'penyidikan-update',
            ],
            [
                "name" => 'penyidikan-delete',
            ],
            [
                "name" => 'tuntutan-list',
            ],
            [
                "name" => 'tuntutan-create',
            ],
            [
                "name" => 'tuntutan-update',
            ],
            [
                "name" => 'tuntutan-delete',
            ],
            [
                "name" => 'eksekusi-list',
            ],
            [
                "name" => 'eksekusi-create',
            ],
            [
                "name" => 'eksekusi-update',
            ],
            [
                "name" => 'eksekusi-delete',
            ],
            [
                "name" => 'report-list',
            ],
            [
                "name" => 'monev-list',
            ]
        ];
        foreach ($datas as $data){
            Permission::updateOrCreate(['name' => $data["name"]]);
        }
        $this->command->info('Proses seeder selesai. Terimakasih DevOps...');

    }
}
