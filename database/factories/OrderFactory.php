<?php

namespace Database\Factories;

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
        'address' => "string",
        'order_comment' => "string",
        'delivery_date' => "string",
        'created_at' => "string",
        'user_id' => "int"
    ])]
    public function definition(): array
    {
        return [
            'address' => $this->faker->text(5),
            'order_comment' => $this->faker->text(5),
            'delivery_date' => $this->faker->date(),
            'created_at' => date(now()),
            'user_id' => $this->faker->numberBetween(1, 6)
        ];
    }
}
