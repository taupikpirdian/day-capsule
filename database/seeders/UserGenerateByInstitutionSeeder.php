<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Access;
use Illuminate\Database\Seeder;
use App\Models\InstitutionCategoryPart;

class UserGenerateByInstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Seeder generate user seeder dimulai ... ');

        $dataInstitutions = InstitutionCategoryPart::orderBy('created_at', 'desc')->get();
        foreach ($dataInstitutions as $di){
            $addFormatMail = $di->code . '@mail.com';
            // Seed Users with Roles
            $user = User::updateOrCreate(
                [
                    'email' => $addFormatMail,
                ],
                [
                    'name' => $di->name,
                    'password' => bcrypt('s!r!m4u123'),
                ]
            );


            if($di->institution_category_id == 1){
                $user->assignRole(ROLE_KEJARI);
            }else{
                $user->assignRole(ROLE_KEJATI);
            }

            /**
             * add access
             */
            Access::updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'institution_category_part_id' => $di->id,
                ]
            );
        }
        $this->command->info('Seeder generate user seeder selesai ... ');
    }
}
