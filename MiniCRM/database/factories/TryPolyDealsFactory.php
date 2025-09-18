<?php

namespace Database\Factories;

use App\Models\Customers;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TryPolyDeals>
 */
class TryPolyDealsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       $dealstatus = \App\Models\DealStatus::inRandomOrder()->first()->id;
       $s = $this->faker->randomElement([
        Customers::class
       ]);
        return [
            'users_id' => \App\Models\User::inRandomOrder()->first()->id,
            'dealable_id' => $s::factory(),
            'dealable_type' => $s,
            'title' => fake()->words(3, true),
            'amount' => fake()->numberBetween(100, 10000),
            'deal_status_id' => $dealstatus,
            'expected_close_at' => fake()->dateTimeBetween('tomorrow', '+1 month')->format('Y-m-d'),
            'won_at' => $dealstatus == 4 ? fake()->optional()->dateTimeBetween('tomorrow', '+1 month') : null,
            'position' => fake()->numberBetween(0, 100),
        ];
    }
}
