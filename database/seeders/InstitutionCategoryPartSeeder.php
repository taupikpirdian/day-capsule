<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InstitutionCategoryPart;

class InstitutionCategoryPartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Seeder institution category part seeder dimulai ... ');

        $datas = [
            [
                "id" => 1,
                "institution_category_id" => 1,
                "code" => "kn_palembang",
                "name" => 'KEJAKSAAN NEGERI PALEMBANG',
            ],
            [
                "id" => 2,
                "institution_category_id" => 1,
                "code" => "kn_banyuasin",
                "name" => 'KEJAKSAAN NEGERI BANYUASIN',
            ],
            [
                "id" => 3,
                "institution_category_id" => 1,
                "code" => "kn_muba",
                "name" => 'KEJAKSAAN NEGERI MUSI BANYUASIN',
            ],
            [
                "id" => 4,
                "institution_category_id" => 1,
                "code" => "kn_lubuk_linggau",
                "name" => 'KEJAKSAAN NEGERI LUBUK LINGGAU',
            ],
            [
                "id" => 5,
                "institution_category_id" => 1,
                "code" => "kn_oi",
                "name" => 'KEJAKSAAN NEGERI OGAN ILIR',
            ],
            [
                "id" => 6,
                "institution_category_id" => 1,
                "code" => "kn_oki",
                "name" => 'KEJAKSAAN NEGERI OGAN KOMERING ILIR',
            ],
            [
                "id" => 7,
                "institution_category_id" => 1,
                "code" => "kn_prabumulih",
                "name" => 'KEJAKSAAN NEGERI PRABUMULIH',
            ],
            [
                "id" => 8,
                "institution_category_id" => 1,
                "code" => "kn_muara_enim",
                "name" => 'KEJAKSAAN NEGERI MUARA ENIM',
            ],
            [
                "id" => 9,
                "institution_category_id" => 1,
                "code" => "kn_pali",
                "name" => 'KEJAKSAAN NEGERI PENUKAL ABAB LEMATANG ILIR',
            ],
            [
                "id" => 10,
                "institution_category_id" => 1,
                "code" => "kn_pagar_alam",
                "name" => 'KEJAKSAAN NEGERI PAGAR ALAM',
            ],
            [
                "id" => 11,
                "institution_category_id" => 1,
                "code" => "kn_lahat",
                "name" => 'KEJAKSAAN NEGERI LAHAT',
            ],
            [
                "id" => 12,
                "institution_category_id" => 1,
                "code" => "kn_empat_lawang",
                "name" => 'KEJAKSAAN NEGERI EMPAT LAWANG',
            ],
            [
                "id" => 13,
                "institution_category_id" => 1,
                "code" => "kn_oku",
                "name" => 'KEJAKSAAN NEGERI OGAN KOMERING ULU',
            ],
            [
                "id" => 14,
                "institution_category_id" => 1,
                "code" => "kn_okut",
                "name" => 'KEJAKSAAN NEGERI OGAN KOMERING ULU TIMUR',
            ],
            [
                "id" => 15,
                "institution_category_id" => 1,
                "code" => "kn_okus",
                "name" => 'KEJAKSAAN NEGERI OGAN KOMERING ULU SELATAN',
            ],
            [
                "id" => 16,
                "institution_category_id" => 2,
                "code" => "kt_palembang",
                "name" => 'KEJAKSAAN TINGGI SUMATERA SELATAN',
            ],
        ];

        InstitutionCategoryPart::truncate();
        InstitutionCategoryPart::insert($datas);

        $this->command->info('Seeder institution category seeder selesai ... ');
    }
}
