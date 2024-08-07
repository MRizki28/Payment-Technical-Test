<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TransactionModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = ['pending', 'completed', 'failed'];

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'amount' => $this->faker->randomFloat(2, 0, 1000000),
            'status' => $this->faker->randomElement($status),
        ];
    }
}
