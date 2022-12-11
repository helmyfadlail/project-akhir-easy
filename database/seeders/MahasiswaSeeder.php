<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i=1; $i <= 10; $i++) { 
            DB::table('users')->insert([
                'nim' => $faker->unique()->randomNumber(9, true),
                'nama' => $faker->name,
                'angkatan' => 2020,
                'password' => Hash::make('password'),
            ]);
        }
    }
}
