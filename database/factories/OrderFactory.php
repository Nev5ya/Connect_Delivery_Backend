<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends Factory
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape([
        'name' => "string",
        'address' => "string",
        'comment' => "string",
        'delivery_date' => "string",
        'created_at' => "string",
        'user_id' => "int",
        'order_status_id' => "int"
    ])]
    public function definition(): array
    {
        $address = $this->faker->city . ', ' . $this->faker->streetAddress;

        return [
            'name' => $this->faker->jobTitle,
            'address' => $address,
            'comment' => $this->faker->realTextBetween(10, 50),
            'delivery_date' => $this->faker->dateTimeBetween('-3 months', '+1 year')->format('Y-m-d'),
            'order_status_id' => $this->faker->numberBetween(1, 3),
            'user_id' => null,
            'created_at' => date(now()),
        ];
    }
}
