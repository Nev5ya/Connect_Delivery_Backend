<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('ru_RU');

        DB::table('users')->insert([
            [
                'name' => $faker->name(),
                'email' => 'signatov@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456789'),
                'role_id' => 1,
                'user_status_id' => 2,
                'coords' => '55.684758,37.338521',
                'remember_token' => Str::random(10),
                'created_at' => date(now())
            ],
            [
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make('123456789'),
                'role_id' => 1,
                'user_status_id' => 3,
                'coords' => '55.8,37.7',
                'remember_token' => Str::random(10),
                'created_at' => date(now())
            ],
            [
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make('123456789'),
                'role_id' => 1,
                'user_status_id' => 1,
                'coords' => '55.9,37.9',
                'remember_token' => Str::random(10),
                'created_at' => date(now())
            ],
            [
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make('123456789'),
                'role_id' => 1,
                'user_status_id' => 2,
                'coords' => '55.4,37.9',
                'remember_token' => Str::random(10),
                'created_at' => date(now())
            ]
        ]);
    }
}
