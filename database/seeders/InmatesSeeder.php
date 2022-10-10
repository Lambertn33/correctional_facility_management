<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InmatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('inmates')->delete();

        DB::table('inmates')->insert(array(
            0 =>array(
                'id' => Str::uuid()->toString(),
                'names' => 'Inmate 1',
                'prison_id' => 'a406ad0c-2b49-4d1c-a1eb-b1ad2bc298a2',
                'national_id' => 1111111111111116,
                'father_names' => 'Male Parent 1',
                'mother_names' => 'Female Parent 1',
                'in_date' => now()->format('Y-m-d'),
                'inmate_code' => 'Inmate1Code',
                'reason' => 'Robbery',
                'status' => \App\Models\Inmate::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ),
            1 =>array(
                'id' => Str::uuid()->toString(),
                'names' => 'Inmate 2',
                'prison_id' => 'a406ad0c-2b49-4d1c-a1eb-b1ad2bc298a2',
                'national_id' => 1111111111111115,
                'father_names' => 'Male Parent 2',
                'mother_names' => 'Female Parent 2',
                'in_date' => now()->format('Y-m-d'),
                'inmate_code' => 'Inmate2Code',
                'reason' => 'Killing',
                'status' => \App\Models\Inmate::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ),
            2 =>array(
                'id' => Str::uuid()->toString(),
                'names' => 'Inmate 3',
                'prison_id' => '6e8bb547-96a5-406b-a947-96bb0760745e',
                'national_id' => 1111111111111114,
                'father_names' => 'Male Parent 3',
                'mother_names' => 'Female Parent 3',
                'in_date' => now()->format('Y-m-d'),
                'inmate_code' => 'Inmate3Code',
                'reason' => 'Killing',
                'status' => \App\Models\Inmate::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ),
            3 =>array(
                'id' => Str::uuid()->toString(),
                'names' => 'Inmate 4',
                'prison_id' => '6e8bb547-96a5-406b-a947-96bb0760745e',
                'national_id' => 1111111111111113,
                'father_names' => 'Male Parent 4',
                'mother_names' => 'Female Parent 4',
                'in_date' => now()->format('Y-m-d'),
                'inmate_code' => 'Inmate4Code',
                'reason' => 'Violence',
                'status' => \App\Models\Inmate::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ),
            4 =>array(
                'id' => Str::uuid()->toString(),
                'names' => 'Inmate 5',
                'prison_id' => 'c7a610c1-2f17-4b5f-b3a8-07e3782fbe78',
                'national_id' => 1111111111111112,
                'father_names' => 'Male Parent 5',
                'mother_names' => 'Female Parent 5',
                'in_date' => now()->format('Y-m-d'),
                'inmate_code' => 'Inmate5Code',
                'reason' => 'Bank Robbery',
                'status' => \App\Models\Inmate::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ),
            5 =>array(
                'id' => Str::uuid()->toString(),
                'names' => 'Inmate 6',
                'prison_id' => 'c7a610c1-2f17-4b5f-b3a8-07e3782fbe78',
                'national_id' => 1111111111111111,
                'father_names' => 'Male Parent 6',
                'mother_names' => 'Female Parent 6',
                'in_date' => now()->format('Y-m-d'),
                'inmate_code' => 'Inmate6Code',
                'reason' => 'Stealing',
                'status' => \App\Models\Inmate::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ),
        ));
    }
}
