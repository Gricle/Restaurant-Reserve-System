<?php

namespace Database\Seeders;

use App\Models\Reserve;
use Illuminate\Database\Seeder;

class ReservesTableSeeder extends Seeder
{
    public function run(): void
    {
        Reserve::factory()
            ->count(40)
            ->create();
    }
}