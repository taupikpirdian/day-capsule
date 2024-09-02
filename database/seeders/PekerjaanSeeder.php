<?php

namespace Database\Seeders;

use App\Models\Pekerjaan;
use Illuminate\Database\Seeder;

class PekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        $this->command->info('Seeder Pekerjaan seeder dimulai ... ');
        $datas = [
            [
                "name" => 'Pejabat Negara Lembaga Tinggi',
            ],
            [
                "name" => 'Menteri',
            ],
            [
                "name" => 'Gubernur',
            ],
            [
                "name" => 'Hakim',
            ],
            [
                "name" => 'Dubes',
            ],
            [
                "name" => 'Wakil Gubernur',
            ],
            [
                "name" => 'Bupati/Walikota',
            ],
            [
                "name" => 'Direksi Komisaris BUMN/BUMD',
            ],
            [
                "name" => 'Pimpinan BI',
            ],
            [
                "name" => 'Rektor/ Warek',
            ],
            [
                "name" => 'Pejabat Eselon 1',
            ],
            [
                "name" => 'Pimpinan DPRD',
            ],
            [
                "name" => 'Jaksa',
            ],
            [
                "name" => 'Penyidik',
            ],
            [
                "name" => 'Panitera',
            ],
            [
                "name" => 'Pimpinan dan Bendahara Proyek',
            ],
            [
                "name" => 'Swasta',
            ],
            [
                "name" => 'ASN',
            ],
            [
                "name" => 'PNS',
            ],
            [
                "name" => 'Lainnya',
            ],
        ];
        foreach ($datas as $data){
            Pekerjaan::updateOrCreate(['name' => $data["name"]]);
        }
        $this->command->info('Proses seeder selesai. Terimakasih DevOps...');
    }
}
