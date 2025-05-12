<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function index()
    {
        return Cache::remember('weather_forecast', now()->addHours(12), function () {
            $cities = [
                ['name' => 'New York', 'lat' => 40.7128, 'lon' => -74.006],
                ['name' => 'London', 'lat' => 51.5074, 'lon' => -0.1278],
                ['name' => 'Tokyo', 'lat' => 35.6895, 'lon' => 139.6917],
                ['name' => 'Paris', 'lat' => 48.8566, 'lon' => 2.3522],
                ['name' => 'Berlin', 'lat' => 52.52, 'lon' => 13.405],
                ['name' => 'Dubai', 'lat' => 25.276987, 'lon' => 55.296249],
                ['name' => 'Belgrade', 'lat' => 44.7866, 'lon' => 20.4489],
                ['name' => 'Niš', 'lat' => 43.319, 'lon' => 21.896],
                ['name' => 'Munich', 'lat' => 48.1351, 'lon' => 11.5820],
            ];

            $results = [];

            foreach ($cities as $city) {
                $res = Http::get("https://api.open-meteo.com/v1/forecast", [
                    'latitude' => $city['lat'],
                    'longitude' => $city['lon'],
                    'daily' => 'temperature_2m_max,temperature_2m_min',
                    'timezone' => 'auto',
                    'start_date' => now()->toDateString(),
                    'end_date' => now()->addDays(3)->toDateString(),
                ]);

                if ($res->successful()) {
                    $data = $res->json();
                    $results[] = [
                        'name' => $city['name'],
                        'max' => $data['daily']['temperature_2m_max'][0],
                        'min' => $data['daily']['temperature_2m_min'][0],
                    ];
                }
            }

            return $results;
        });
    }
}
