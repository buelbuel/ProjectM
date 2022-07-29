<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'project_id' => Project::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'name' => $this->faker->text(50),
            'description' => $this->faker->text(250),
            'status_id' => $this->faker->numberBetween(1,5),
            'priority_id' => $this->faker->numberBetween(1,5),
            'created_by' => User::all()->random()->id,
            'created_at' => $this->faker->dateTime,
            'updated_at' => null,
            'deleted_at' => null,
            'completed_at' => null,
            'tracked' => $this->faker->numberBetween(1,8),
            'estimated' => $this->faker->numberBetween(1,8),
            'start_date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
        ];
    }
}
