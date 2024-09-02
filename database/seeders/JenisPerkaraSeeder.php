<?php

namespace Database\Seeders;

use App\Models\JenisPerkara;
use Illuminate\Database\Seeder;

class JenisPerkaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Seeder jenis perkara seeder dimulai ... ');

        $datas = [
            [
                "name" => 'TIPIKOR',
            ],
            [
                "name" => 'TPPU',
            ],
            [
                "name" => 'PERPAJAKAN',
            ],
            [
                "name" => 'BEA CUKAI',
            ]
        ];
        foreach ($datas as $data){
            JenisPerkara::updateOrCreate(['name' => $data["name"]]);
        }

        $this->command->info('Seeder jenis perkara seeder selesai ... ');
    }
}
