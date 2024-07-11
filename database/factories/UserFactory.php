<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'username' => $this->faker->unique()->userName(),
            'password' => Hash::make('password'),
            'nationalCode' => $this->faker->unique()->numerify('##########'),
            'phone' => $this->faker->unique()->numerify('09########'),
            'email' => $this->faker->unique()->safeEmail(),
            'is_blocked' => $this->faker->boolean(10),
        ];
    }
}