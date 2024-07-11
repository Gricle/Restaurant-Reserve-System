<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FoodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $meals = ['Breakfast', 'Lunch', 'Dinner'];
        $categories = ['Italian', 'Mexican', 'Chinese', 'American', 'Vegetarian'];

        return [
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 5, 25),
            'image' => $this->faker->imageUrl(),
            'category' => $this->faker->randomElement($categories),
            'meal' => $this->faker->randomElement($meals),
        ];
    }
}
