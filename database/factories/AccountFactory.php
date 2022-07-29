<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'created_by' => User::all()->random()->id,
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'fax' => $this->faker->phoneNumber(),
            'shipping_street' => $this->faker->streetName(),
            'shipping_city' => $this->faker->city(),
            'shipping_zip' => $this->faker->randomNumber(5),
            'shipping_state' =>  '',
            'shipping_country' => $this->faker->country(),
            'billing_street' => $this->faker->streetName(),
            'billing_city' => $this->faker->city(),
            'billing_zip' => $this->faker->randomNumber(5),
            'billing_state' =>  '',
            'billing_country' => $this->faker->country(),
        ];
    }
}
