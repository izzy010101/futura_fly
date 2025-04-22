<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Flight;
use Faker\Factory as Faker;


class FlightSeeder extends Seeder
{
    public function run(): void
    {
        Flight::factory()->count(50)->create();
    }
}
