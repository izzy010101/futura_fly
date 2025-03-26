<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\FlightSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'password' => bcrypt('password'),
        ]);

        $this->call([
            FlightSeeder::class,
        ]);
    }
}
