<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        DB::table('roles')->insert(array(
            0 => array (
                'id' => Str::uuid()->toString(),
                'name' => \App\Models\Role::SUPER_ADMINISTRATOR,
                'created_at' => now(),
                'updated_at' => now()
            ),
            1 => array (
                'id' => Str::uuid()->toString(),
                'name' => \App\Models\Role::ADMINISTRATOR,
                'created_at' => now(),
                'updated_at' => now()
            ),
        ));
    }
}
