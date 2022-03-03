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
        'address' => "string",
        'comment' => "string",
        'delivery_date' => "string",
        'created_at' => "string",
        'user_id' => "int"
    ])]
    public function definition(): array
    {
        $user_id = rand(2, User::all()->count());
        return [
            'address' => $this->faker->streetAddress(),
            'comment' => $this->faker->realText(rand(15, 50)),
            'delivery_date' => $this->faker->dateTime(),
            'created_at' => date(now()),
            'user_id' => $user_id
        ];
    }
}
