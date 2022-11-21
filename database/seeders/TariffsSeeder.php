<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TariffsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tariffs')->delete();

        DB::table('tariffs')->insert(array(
            0 => array(
                'id' => Str::uuid()->toString(),
                'time' => 10,
                'amount' => 100,
                'created_at' => now(),
                'updated_at' => now()
            ),
            1 => array(
                'id' => Str::uuid()->toString(),
                'time' => 15,
                'amount' => 150,
                'created_at' => now(),
                'updated_at' => now()
            ),
            2 => array(
                'id' => Str::uuid()->toString(),
                'time' => 30,
                'amount' => 300,
                'created_at' => now(),
                'updated_at' => now()
            ),
        ));
    }
}
