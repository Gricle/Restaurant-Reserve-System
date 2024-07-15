<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $baseUrl = '/api/api/users';

    public function test_can_get_all_users()
    {
        $users = User::factory()->count(3)->create();

        $response = $this->getJson($this->baseUrl);

        $this->assertEquals(200, $response->status(), "Response status is not 200. Response content: " . $response->content());
        $responseData = $response->json('data');
        $this->assertIsArray($responseData, "Response data is not an array. Response content: " . $response->content());
        $this->assertCount(3, $responseData, "Response does not contain 3 users. Response content: " . $response->content());
    }

    public function test_can_create_user()
    {
        $userData = [
            'username' => $this->faker->userName,
            'password' => 'password123',
            'nationalCode' => $this->faker->unique()->numerify('##########'),
            'phone' => $this->faker->numerify('#########'),
            'email' => $this->faker->unique()->safeEmail,
            'imgURL' => $this->faker->imageUrl(),
            'is_blocked' => false,
        ];

        $response = $this->postJson($this->baseUrl, $userData);

        $this->assertEquals(201, $response->status(), "Response status is not 201. Response content: " . $response->content());
        $this->assertArrayHasKey('data', $response->json(), "Response does not have a 'data' key. Response content: " . $response->content());

        $this->assertDatabaseHas('users', [
            'username' => $userData['username'],
            'email' => $userData['email'],
            'nationalCode' => $userData['nationalCode'],
        ]);
    }

    public function test_can_get_single_user()
    {
        $user = User::factory()->create();

        $response = $this->getJson("{$this->baseUrl}/{$user->id}");

        $this->assertEquals(200, $response->status(), "Response status is not 200. Response content: " . $response->content());
        $this->assertEquals($user->id, $response->json('data.id'), "User ID does not match. Response content: " . $response->content());
    }

    public function test_can_update_user()
    {
        $user = User::factory()->create();

        $updatedData = [
            'username' => 'newusername',
            'email' => 'newemail@example.com',
            'phone' => '1234567890',
        ];

        $response = $this->putJson("{$this->baseUrl}/{$user->id}", $updatedData);

        $this->assertEquals(200, $response->status(), "Response status is not 200. Response content: " . $response->content());
        $this->assertEquals('newusername', $response->json('data.username'), "Username was not updated. Response content: " . $response->content());
    }

    public function test_can_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("{$this->baseUrl}/{$user->id}");

        $this->assertEquals(204, $response->status(), "Response status is not 204. Response content: " . $response->content());
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}