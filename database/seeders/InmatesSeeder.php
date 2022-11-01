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
                'names' => 'Eric',
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
                'names' => 'John',
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
                'names' => 'Mary',
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
                'names' => 'Lambert',
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
                'names' => 'Octave',
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
                'names' => 'Heritier',
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
            6 =>array(
                'id' => Str::uuid()->toString(),
                'names' => 'Rakia',
                'prison_id' => 'c7a610c1-2f17-4b5f-b3a8-07e3782fbe78',
                'national_id' => 1111111111111117,
                'father_names' => 'Male Parent 7',
                'mother_names' => 'Female Parent 7',
                'in_date' => now()->format('Y-m-d'),
                'inmate_code' => 'Inmate7Code',
                'reason' => 'Bank Robbery',
                'status' => \App\Models\Inmate::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ),
            7 =>array(
                'id' => Str::uuid()->toString(),
                'names' => 'Kevin',
                'prison_id' => 'c7a610c1-2f17-4b5f-b3a8-07e3782fbe78',
                'national_id' => 1111111111111118,
                'father_names' => 'Male Parent 8',
                'mother_names' => 'Female Parent 8',
                'in_date' => now()->format('Y-m-d'),
                'inmate_code' => 'Inmate8Code',
                'reason' => 'Stealing',
                'status' => \App\Models\Inmate::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ),
            8 =>array(
                'id' => Str::uuid()->toString(),
                'names' => 'Emerthe',
                'prison_id' => '6e8bb547-96a5-406b-a947-96bb0760745e',
                'national_id' => 1111111111111119,
                'father_names' => 'Male Parent 9',
                'mother_names' => 'Female Parent 9',
                'in_date' => now()->format('Y-m-d'),
                'inmate_code' => 'Inmate9Code',
                'reason' => 'Killing',
                'status' => \App\Models\Inmate::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ),
            9 =>array(
                'id' => Str::uuid()->toString(),
                'names' => 'Gerard',
                'prison_id' => '6e8bb547-96a5-406b-a947-96bb0760745e',
                'national_id' => 1111111111111120,
                'father_names' => 'Male Parent 10',
                'mother_names' => 'Female Parent 10',
                'in_date' => now()->format('Y-m-d'),
                'inmate_code' => 'Inmate10Code',
                'reason' => 'Violence',
                'status' => \App\Models\Inmate::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ),
            10 =>array(
                'id' => Str::uuid()->toString(),
                'names' => 'Japhet',
                'prison_id' => 'a406ad0c-2b49-4d1c-a1eb-b1ad2bc298a2',
                'national_id' => 1111111111111121,
                'father_names' => 'Male Parent 11',
                'mother_names' => 'Female Parent 11',
                'in_date' => now()->format('Y-m-d'),
                'inmate_code' => 'Inmate11Code',
                'reason' => 'Robbery',
                'status' => \App\Models\Inmate::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ),
            11 =>array(
                'id' => Str::uuid()->toString(),
                'names' => 'Bob',
                'prison_id' => 'a406ad0c-2b49-4d1c-a1eb-b1ad2bc298a2',
                'national_id' => 1111111111111122,
                'father_names' => 'Male Parent 12',
                'mother_names' => 'Female Parent 12',
                'in_date' => now()->format('Y-m-d'),
                'inmate_code' => 'Inmate12Code',
                'reason' => 'Killing',
                'status' => \App\Models\Inmate::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ),
        ));
    }
}
