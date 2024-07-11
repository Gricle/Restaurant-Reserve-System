<?php

namespace Database\Seeders;

use App\Models\ReserveFood;
use Illuminate\Database\Seeder;

class ReserveFoodTableSeeder extends Seeder
{
    public function run(): void
    {
        ReserveFood::factory()
            ->count(20)
            ->create();
    }
}