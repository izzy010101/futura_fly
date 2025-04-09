<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Addon;

class AddonSeeder extends Seeder
{


    public function run()
    {
        Addon::insert([
            ['name' => 'Extra Baggage', 'description' => 'Up to 20kg extra', 'price' => 30, 'unit' => 'per 10kg'],
            ['name' => 'Seat Selection', 'description' => 'Choose window or aisle', 'price' => 12, 'unit' => ''],
            ['name' => 'Premium Meals', 'description' => 'Vegetarian and gluten-free', 'price' => 18, 'unit' => 'per meal'],
            ['name' => 'Airport Lounge Access', 'description' => 'Worldwide access', 'price' => 25, 'unit' => 'per pass'],
            ['name' => 'Fast Track Security', 'description' => 'Priority security lane', 'price' => 15, 'unit' => 'per person'],
            ['name' => 'Travel Insurance', 'description' => 'Cancellations and loss', 'price' => 22, 'unit' => 'starting from'],
        ]);
    }

}
