<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Food;

class FoodApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $baseUrl = '/api/api/foods';

    public function test_can_get_all_foods()
    {
        Food::factory()->count(3)->create();

        $response = $this->getJson($this->baseUrl);

        $this->assertEquals(200, $response->status(), "Response status is not 200. Response content: " . $response->content());
        $responseData = $response->json('data');
        $this->assertIsArray($responseData, "Response data is not an array. Response content: " . $response->content());
        $this->assertCount(3, $responseData, "Response does not contain 3 foods. Response content: " . $response->content());
    }

    public function test_can_create_food()
    {
        $foodData = [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(1, 100),
            'image' => $this->faker->imageUrl(),
            'category' => $this->faker->word,
            'meal' => $this->faker->randomElement(['breakfast', 'lunch', 'dinner']),
        ];

        $response = $this->postJson($this->baseUrl, $foodData);

        $this->assertEquals(201, $response->status(), "Response status is not 201. Response content: " . $response->content());
        $this->assertArrayHasKey('data', $response->json(), "Response does not have a 'data' key. Response content: " . $response->content());

        $this->assertDatabaseHas('foods', [
            'name' => $foodData['name'],
            'description' => $foodData['description'],
            'price' => $foodData['price'],
            'category' => $foodData['category'],
            'meal' => $foodData['meal'],
        ]);
    }

    public function test_can_get_single_food()
    {
        $food = Food::factory()->create();

        $response = $this->getJson("{$this->baseUrl}/{$food->id}");

        $this->assertEquals(200, $response->status(), "Response status is not 200. Response content: " . $response->content());
        $this->assertEquals($food->id, $response->json('data.id'), "Food ID does not match. Response content: " . $response->content());
    }

    public function test_can_update_food()
    {
        $food = Food::factory()->create();

        $updatedData = [
            'name' => 'Updated Food Name',
            'description' => 'Updated food description',
            'price' => 150,
            'category' => 'Updated Category',
            'meal' => 'dinner',
        ];

        $response = $this->putJson("{$this->baseUrl}/{$food->id}", $updatedData);

        $this->assertEquals(200, $response->status(), "Response status is not 200. Response content: " . $response->content());
        $this->assertEquals('Updated Food Name', $response->json('data.name'), "Food name was not updated. Response content: " . $response->content());
    }

    public function test_cannot_create_food_with_invalid_data()
    {
        $invalidData = [
            'name' => '',
            'description' => '',
            'price' => 'not a number',
            'category' => '',
            'meal' => 'invalid meal',
        ];

        $response = $this->postJson($this->baseUrl, $invalidData);

        $this->assertEquals(422, $response->status(), "Response status is not 422. Response content: " . $response->content());
        $responseData = $response->json();
        $this->assertArrayHasKey('errors', $responseData, "Response does not have an 'errors' key. Response content: " . $response->content());
    }

    public function test_cannot_update_food_with_invalid_data()
    {
        $food = Food::factory()->create();

        $invalidData = [
            'name' => '',
            'price' => 'not a number',
            'meal' => 'invalid meal',
        ];

        $response = $this->putJson("{$this->baseUrl}/{$food->id}", $invalidData);

        $this->assertEquals(422, $response->status(), "Response status is not 422. Response content: " . $response->content());
        $responseData = $response->json();
        $this->assertArrayHasKey('errors', $responseData, "Response does not have an 'errors' key. Response content: " . $response->content());
    }
}