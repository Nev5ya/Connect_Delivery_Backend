<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->insert([
            [
                'name' => 'Пицца',
                'address' => 'Москва, Мясницкая, 22',
                'comment' => 'Стол, кресла, стулья — все если нет.',
                'delivery_date' => '2020-12-05',
                'order_status_id' => 2,
                'user_id' => 4,
                'created_at' => date(now())
            ],
            [
                'name' => 'Канцелярские товары',
                'address' => 'Москва, Варварка, 8',
                'comment' => 'Доставить ко времени.',
                'delivery_date' => '2012-11-14',
                'order_status_id' => 1,
                'user_id' => 2,
                'created_at' => date(now())
            ],
            [
                'name' => 'Холодильник',
                'address' => 'Москва, Октябрьская улица, 37',
                'comment' => 'Предварительно позвонить.',
                'delivery_date' => '2013-12-05',
                'order_status_id' => 3,
                'user_id' => 3,
                'created_at' => date(now())
            ]
        ]);
    }
}
