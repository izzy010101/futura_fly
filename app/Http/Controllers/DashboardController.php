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

        $bookings = Booking::with(['flight', 'addons'])
            ->where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'price' => $booking->price, // saved price in DB (discounted or full)
                    'created_at' => $booking->created_at,
                    'flight' => [
                        'id' => $booking->flight->id,
                        'flight_number' => $booking->flight->flight_number,
                        'price' => $booking->flight->price, // original flight price
                        'departure' => $booking->flight->departure,
                        'destination' => $booking->flight->destination,
                    ],
                    'addons' => $booking->addons->map(function ($addon) {
                        return [
                            'id' => $addon->id,
                            'name' => $addon->name,
                            'price' => $addon->price,
                        ];
                    }),
                    // Check if this booking was discounted when stored
                    'is_discounted' => $booking->price < $booking->flight->price,
                    // Optional: calculate expected discount (can help in the frontend)
                    'expected_discounted_price' => round($booking->flight->price * 0.88, 2),
                ];
            });

        return Inertia::render('Dashboard', [
            'auth' => [
                'user' => $user
            ],
            'bookings' => $bookings,
        ]);
    }
}
