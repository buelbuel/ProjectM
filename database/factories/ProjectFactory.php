<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'account_id' => Account::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'name' => $this->faker->word(),
            'description' => $this->faker->realText(200),
            'status' => $this->faker->randomElement(['Backlog', 'In Progress', 'In Testing', 'Completed']),
            'created_by' => User::all()->random()->id,
            'created_at' => $this->faker->dateTime,
            'updated_at' => null,
            'deleted_at' => null,
            'completed_at' => null,
            'hourly_rate' => $this->faker->randomNumber(2),
        ];
    }
}
