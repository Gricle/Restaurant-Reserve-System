<?php

namespace Database\Factories;

use App\Models\Reserve;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReserveFactory extends Factory
{
    protected $model = Reserve::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'date' => $this->faker->date('Y-m-d'),
            'time' => $this->faker->time('H:i'),
        ];
    }
}