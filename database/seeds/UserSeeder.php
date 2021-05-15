<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create();

        $user = DB::table('users')->insert([
                'id' => 1,
                'email' => 'admin@gmail.com',
                'name' => 'Admin',
                'role'=>'1',
                'password'=>Hash::make('12345678'),
                'created_at' => $faker->datetimeBetween('-5 months'),
            ]
        );

        $user = DB::table('users')->insert([
                'id' => 2,
                'email' => 'manager@gmail.com',
                'name' => 'Manager',
                'role'=>'2',
                'password'=>Hash::make('12345678'),
                'created_at' => $faker->datetimeBetween('-5 months'),
            ]
        );

        $user = DB::table('users')->insert([
                'id' => 3,
                'email' => 'staff1@gmail.com',
                'name' => 'staff1',
                'role'=>'3',
                'password'=>Hash::make('12345678'),
                'created_at' => $faker->datetimeBetween('-5 months'),

            ]
        );

        $user = DB::table('users')->insert([
                'id' => 4,
                'email' => 'staff2@gmail.com',
                'name' => 'staff2',
                'role'=>'3',
                'password'=>Hash::make('12345678'),
                'created_at' => $faker->datetimeBetween('-5 months'),
            ]
        );

    }
}
