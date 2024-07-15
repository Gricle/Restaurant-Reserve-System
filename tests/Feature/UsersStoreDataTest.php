<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersStoreDataTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_users_table_stores_data()
    {
        // Arrange: Prepare user data
        $plainPassword = 'password123';
        $userData = [
            'username' => $this->faker->userName,
            'password' => Hash::make($plainPassword), // Use Hash::make() to properly hash the password
            'nationalCode' => $this->faker->unique()->numerify('##########'),
            'phone' => $this->faker->numerify('#########'), // Generate a 10-digit phone number
            'email' => $this->faker->unique()->safeEmail,
            'imgURL' => $this->faker->imageUrl(),
            'is_blocked' => false,
        ];

        // Act: Create the user
        $user = User::create($userData);

        // Assert: Check if the user exists in the database
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'username' => $userData['username'],
            'nationalCode' => $userData['nationalCode'],
            'phone' => $userData['phone'],
            'email' => $userData['email'],
            'imgURL' => $userData['imgURL'],
            'is_blocked' => $userData['is_blocked'],
        ]);

        // Additional assertions
        $this->assertTrue(Hash::check($plainPassword, $user->password), 'Password was not hashed correctly');
        
        $storedUser = User::find($user->id);
        $this->assertNotNull($storedUser, 'User was not found in the database');
        $this->assertEquals($userData['username'], $storedUser->username, 'Username does not match');
        $this->assertEquals($userData['email'], $storedUser->email, 'Email does not match');
        $this->assertEquals($userData['nationalCode'], $storedUser->nationalCode, 'National code does not match');
        $this->assertEquals($userData['phone'], $storedUser->phone, 'Phone number does not match');
        $this->assertEquals($userData['imgURL'], $storedUser->imgURL, 'Image URL does not match');
        $this->assertEquals($userData['is_blocked'], $storedUser->is_blocked, 'Blocked status does not match');
    }
}