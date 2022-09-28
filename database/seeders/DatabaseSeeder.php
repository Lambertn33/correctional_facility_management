<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $this->call(RolesSeeder::class);
       $this->call(UsersSeeder::class);
       $this->call(SuperAdminsSeeder::class);
       $this->call(PrisonsSeeder::class);
       $this->call(AdminsSeeder::class);
       $this->call(InmatesSeeder::class);
       $this->call(TariffsSeeder::class);
    }
}
