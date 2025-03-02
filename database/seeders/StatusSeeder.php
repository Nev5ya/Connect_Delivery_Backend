<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('order_status')->insert([
            [ 'title' => 'В обработке' ],
            [ 'title' => 'В пути' ],
            [ 'title' => 'Доставлено' ]
        ]);
    }
}
