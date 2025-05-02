<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $now = Carbon::now();

        $bookings = Booking::with(['flight', 'addons'])
            ->where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($booking) use ($now) {
                $isSpring = $now->between(Carbon::parse('2025-03-01'), Carbon::parse('2025-05-31'));
                $expectedDiscountedPrice = $isSpring ? round($booking->flight->price * 0.88, 2) : $booking->flight->price;

                return [
                    'id' => $booking->id,
                    'price' => $booking->price, // stored final price
                    'created_at' => $booking->created_at,
                    'flight' => [
                        'id' => $booking->flight->id,
                        'flight_number' => $booking->flight->flight_number,
                        'price' => $booking->flight->price, // original price
                        'departure' => $booking->flight->departure,
                        'destination' => $booking->flight->destination,
                    ],
                    'addons' => $booking->addons ? $booking->addons->map(function ($addon) {
                        return [
                            'id' => $addon->id,
                            'name' => $addon->name,
                            'price' => $addon->price,
                        ];
                    })->toArray() : [],
                    'is_discounted' => $isSpring && $booking->price < $booking->flight->price,
                    'expected_discounted_price' => $expectedDiscountedPrice,
                ];
            });

        return Inertia::render('Dashboard', [
            'auth' => [
                'user' => $user,
            ],
            'bookings' => $bookings,
        ]);
    }
}
