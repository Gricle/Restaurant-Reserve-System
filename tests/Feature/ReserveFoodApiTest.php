<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\ReserveFood;
use App\Models\Reserve;
use App\Models\Food;
use App\Models\User;

class ReserveFoodApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $baseUrl = '/api/api/reserve_food';

    public function test_can_get_all_reserve_foods()
    {
        ReserveFood::factory()->count(3)->create();

        $response = $this->getJson($this->baseUrl);

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'reserve_id', 'food_id']
                ]
            ]);
    }

    public function test_can_create_reserve_food()
    {
        $reserve = Reserve::factory()->create();
        $food = Food::factory()->create();

        $reserveFoodData = [
            'reserve_id' => $reserve->id,
            'food_id' => $food->id,
        ];

        $response = $this->postJson($this->baseUrl, $reserveFoodData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => ['id', 'reserve_id', 'food_id']
            ]);

        $this->assertDatabaseHas('reserve_food', $reserveFoodData);
    }

    public function test_can_get_single_reserve_food()
    {
        $reserveFood = ReserveFood::factory()->create();

        $response = $this->getJson("{$this->baseUrl}/{$reserveFood->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $reserveFood->id,
                    'reserve_id' => $reserveFood->reserve_id,
                    'food_id' => $reserveFood->food_id,
                ]
            ]);
    }

    public function test_can_update_reserve_food()
    {
        $reserveFood = ReserveFood::factory()->create();
        $newReserve = Reserve::factory()->create();
        $newFood = Food::factory()->create();

        $updatedData = [
            'reserve_id' => $newReserve->id,
            'food_id' => $newFood->id,
        ];

        $response = $this->putJson("{$this->baseUrl}/{$reserveFood->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $reserveFood->id,
                    'reserve_id' => $updatedData['reserve_id'],
                    'food_id' => $updatedData['food_id'],
                ]
            ]);

        $this->assertDatabaseHas('reserve_food', $updatedData);
    }

    public function test_can_delete_reserve_food()
    {
        $reserveFood = ReserveFood::factory()->create();

        $response = $this->deleteJson("{$this->baseUrl}/{$reserveFood->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('reserve_food', ['id' => $reserveFood->id]);
    }

    public function test_cannot_create_reserve_food_with_invalid_data()
    {
        $invalidData = [
            'reserve_id' => 999999, // non-existent reserve
            'food_id' => 999999, // non-existent food
        ];

        $response = $this->postJson($this->baseUrl, $invalidData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['reserve_id', 'food_id']);
    }

}