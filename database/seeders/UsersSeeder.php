<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        DB::table('users')->insert(array(
            0 => array(
                'id' => '13a6dd24-d819-4417-ba8e-dd0e37a4868b',
                'role_id' => \App\Models\Role::where('name', \App\Models\Role::SUPER_ADMINISTRATOR)->value('id'),
                'names' => 'super administrator',
                'email' => 'superadministrator@gmail.com',
                'telephone' => Hash::make(250788000000),
                'password' => Hash::make('superadmin12345'),
                'created_at' => now(),
                'updated_at' => now()
            ),
            1 => array(
                'id' => 'fc69955f-39c3-4cab-a976-4b199722dc71',
                'role_id' => \App\Models\Role::where('name', \App\Models\Role::ADMINISTRATOR)->value('id'),
                'names' => 'administrator1',
                'email' => 'administrator1@gmail.com',
                'telephone' => Hash::make(250788111111),
                'password' => Hash::make('admin12345'),
                'created_at' => now(),
                'updated_at' => now()
            ),
            2 => array(
                'id' => '02730f9d-c942-4d2c-9f08-72e2f4e6a472',
                'role_id' => \App\Models\Role::where('name', \App\Models\Role::ADMINISTRATOR)->value('id'),
                'names' => 'administrator2',
                'email' => 'administrator2@gmail.com',
                'telephone' => Hash::make(250788222222),
                'password' => Hash::make('admin12345'),
                'created_at' => now(),
                'updated_at' => now()
            ),
            3 => array(
                'id' => '3887bdd0-0a3b-4f2b-8fc8-b8bdcbf3ac44',
                'role_id' => \App\Models\Role::where('name', \App\Models\Role::ADMINISTRATOR)->value('id'),
                'names' => 'administrator3',
                'email' => 'administrator3@gmail.com',
                'telephone' => Hash::make(250788333333),
                'password' => Hash::make('admin12345'),
                'created_at' => now(),
                'updated_at' => now()
            ),
        ));
    }
}
