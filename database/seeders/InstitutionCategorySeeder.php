<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InstitutionCategory;

class InstitutionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Seeder institution category seeder dimulai ... ');

        $datas = [
            [
                "id" => 1,
                "name" => 'Kejaksaan Negeri',
            ],
            [
                "id" => 2,
                "name" => 'Kejaksaan Tinggi',
            ],
        ];

        InstitutionCategory::truncate();
        InstitutionCategory::insert($datas);

        $this->command->info('Seeder institution category seeder selesai ... ');
    }
}
