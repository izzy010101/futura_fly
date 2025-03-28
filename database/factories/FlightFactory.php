<?php

namespace Database\Factories;

use App\Models\Flight;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<\App\Models\Flight>
 */
class FlightFactory extends Factory
{
    protected $model = Flight::class;

    public function definition(): array
    {
        $cities = ['New York', 'London', 'Paris', 'Rome', 'Dubai', 'Tokyo', 'Toronto', 'Los Angeles', 'Berlin', 'Madrid', 'Sydney', 'Singapore'];

        $departure = $this->faker->randomElement($cities);
        $destination = $this->faker->randomElement(array_diff($cities, [$departure]));

        $departureTime = $this->faker->dateTimeBetween('+1 day', '+15 days');
        $arrivalTime = (clone $departureTime)->modify('+'.rand(2, 10).' hours');

        return [
            'flight_number' => 'FF' . $this->faker->unique()->numberBetween(100, 999),
            'departure' => $departure,
            'destination' => $destination,
            'departure_time' => $departureTime,
            'arrival_time' => $arrivalTime,
            'price' => $this->faker->numberBetween(150, 999),
            'seats_available' => $this->faker->numberBetween(30, 200),
            'last_minute' => $this->faker->boolean(10),
            'first_minute' => $this->faker->boolean(10),
        ];
    }
}
