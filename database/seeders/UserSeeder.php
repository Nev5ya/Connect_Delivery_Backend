<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
    public function run(): void
    {
        $faker = Factory::create('ru_RU');

        DB::table('users')->insert([
            [
                'name' => $faker->name(),
                'email' => 'signatov@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456789'),
                'role_id' => 1,
                'user_status_id' => 1,
                'coords' => '55.684758,37.338521',
                'remember_token' => Str::random(10),
                'created_at' => date(now()),
                'city' => 'Челябинск',
                'date_of_birth' => null,
                'phone' => null
            ],
            [
                'name' => $faker->name(),
                'email' => 'chief@chief.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456789'),
                'role_id' => 3,
                'user_status_id' => 1,
                'coords' => '55.8,37.7',
                'remember_token' => Str::random(10),
                'created_at' => date(now()),
                'city' => 'Москва',
                'date_of_birth' => date(Carbon::createFromDate(1991, 10, 4)),
                'phone' => '79142341312'
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
                'created_at' => date(now()),
                'city' => 'Санкт-Петербург',
                'date_of_birth' => date(Carbon::createFromDate(1989, 4, 6)),
                'phone' => '79268331122'
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
                'created_at' => date(now()),
                'city' => 'Сочи',
                'date_of_birth' => date(Carbon::createFromDate(1999, 1, 14)),
                'phone' => '79883332211'
            ]
        ]);
    }
}
