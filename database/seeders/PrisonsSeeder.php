<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PrisonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('prisons')->delete();

        DB::table('prisons')->insert(array(
            0 => array(
                'id' => 'a406ad0c-2b49-4d1c-a1eb-b1ad2bc298a2',
                'name' => 'NYARUGENGE CORRECTIONAL FACILITY',
                'province' => 'KIGALI',
                'district' => 'KICUKIRO',
                'code' => 'Code 1',
                'created_at' => now(),
                'updated_at' => now()
            ),
            1 => array(
                'id' => '6e8bb547-96a5-406b-a947-96bb0760745e',
                'name' => 'RUBAVU CORRECTIONAL FACILITY',
                'province' => 'KIGALI',
                'district' => 'NYARUGENGE',
                'code' => 'Code 2',
                'created_at' => now(),
                'updated_at' => now()
            ),
            2 => array(
                'id' => 'c7a610c1-2f17-4b5f-b3a8-07e3782fbe78',
                'name' => 'MUHANGA CORRECTIONAL FACILITY',
                'province' => 'KIGALI',
                'district' => 'GASABO',
                'code' => 'Code 3',
                'created_at' => now(),
                'updated_at' => now()
            ),
        ));
    }
}
