<?php

namespace Database\Factories;

use App\Models\Food;
use App\Models\Reserve;
use App\Models\ReserveFood;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReserveFoodFactory extends Factory
{
    protected $model = ReserveFood::class;

    public function definition(): array
    {
        return [
            'reserve_id' => Reserve::factory(),
            'food_id' => Food::factory(),
        ];
    }
}