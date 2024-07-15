<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Reserve;
use App\Models\User;


class ReserveApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $baseUrl = '/api/api/reserves';

    public function test_can_get_all_reserves()
    {
        Reserve::factory()->count(3)->create();

        $response = $this->getJson($this->baseUrl);

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'user_id', 'date', 'time', 'is_payed']
                ]
            ]);
    }

    public function test_can_create_reserve()
    {
        $user = User::factory()->create(['is_blocked' => false]);
        
        // Ensure the user has no unpaid reservations
        Reserve::where('user_id', $user->id)->delete();

        $reserveData = [
            'user_id' => $user->id,
            'date' => $this->faker->date(),
            'time' => $this->faker->time('H:i'),
            'is_payed' => false,
        ];

        $response = $this->postJson($this->baseUrl, $reserveData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => ['id', 'user_id', 'date', 'time', 'is_payed']
            ]);

        $this->assertDatabaseHas('reserves', $reserveData);
    }


    public function test_can_update_reserve()
    {
        $reserve = Reserve::factory()->create();

        $updatedData = [
            'date' => '2023-12-31',
            'time' => '14:30',
            'is_payed' => true,
        ];

        $response = $this->putJson("{$this->baseUrl}/{$reserve->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJson([
                'data' => $updatedData
            ]);

        $this->assertDatabaseHas('reserves', $updatedData);
    }

    public function test_can_delete_reserve()
    {
        $reserve = Reserve::factory()->create();

        $response = $this->deleteJson("{$this->baseUrl}/{$reserve->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('reserves', ['id' => $reserve->id]);
    }

    public function test_cannot_create_reserve_with_invalid_data()
    {
        $invalidData = [
            'user_id' => '',
            'date' => 'not a date',
            'time' => str_repeat('a', 11), // Exceeds max length of 10
            'is_payed' => 'not a boolean',
        ];

        $response = $this->postJson($this->baseUrl, $invalidData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['user_id', 'date', 'time', 'is_payed']);
    }

}
