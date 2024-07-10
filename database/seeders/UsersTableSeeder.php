<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 10 sample users
        User::factory()->count(10)->create([
            'password' => Hash::make('password'),
        ]);

        // Create a blocked user
        User::factory()->create([
            'username' => 'blockeduser',
            'password' => Hash::make('password'),
            'is_blocked' => true,
        ]);
    }
}