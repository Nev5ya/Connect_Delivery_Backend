<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_status')->insert([
            [ 'title' => 'Offline' ],
            [ 'title' => 'Online' ],
            [ 'title' => 'Busy' ]
        ]);
    }
}
