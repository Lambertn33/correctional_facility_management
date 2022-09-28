<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();

        DB::table('admins')->insert(array(
            0 => array(
                'id' => Str::uuid()->toString(),
                'user_id' => 'fc69955f-39c3-4cab-a976-4b199722dc71',
                'prison_id' => 'a406ad0c-2b49-4d1c-a1eb-b1ad2bc298a2',
                'has_changed_password' => true,
                'password_expiration_days' => 60,
                'created_at' => now(),
                'updated_at' => now()
            ),
            1 => array(
                'id' => Str::uuid()->toString(),
                'user_id' => '02730f9d-c942-4d2c-9f08-72e2f4e6a472',
                'prison_id' => '6e8bb547-96a5-406b-a947-96bb0760745e',
                'has_changed_password' => true,
                'password_expiration_days' => 60,
                'created_at' => now(),
                'updated_at' => now()
            ),
            2 => array(
                'id' => Str::uuid()->toString(),
                'user_id' => '3887bdd0-0a3b-4f2b-8fc8-b8bdcbf3ac44',
                'prison_id' => 'c7a610c1-2f17-4b5f-b3a8-07e3782fbe78',
                'has_changed_password' => true,
                'password_expiration_days' => 60,
                'created_at' => now(),
                'updated_at' => now()
            ),
        ));
    }
}
