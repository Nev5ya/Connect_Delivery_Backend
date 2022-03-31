<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
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
        $this->call(RoleSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(UserStatusSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(UserSeeder::class);
//        User::factory(3)->create();
//        $this->call(OrderSeeder::class);
        Order::factory(20)->create();
    }
}
