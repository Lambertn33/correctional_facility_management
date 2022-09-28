<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SuperAdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('super__admins')->delete();

        DB::table('super__admins')->insert(array(
            0 => array(
                'id' => Str::uuid()->toString(),
                'user_id' => '13a6dd24-d819-4417-ba8e-dd0e37a4868b',
                'created_at' => now(),
                'updated_at' => now()
            ),
        ));
    }
}
