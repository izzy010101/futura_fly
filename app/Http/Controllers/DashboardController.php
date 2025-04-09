<?php

namespace App\Http\Controllers;

use App\Models\Booking;
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
            ->get();

        return Inertia::render('Dashboard', [
            'auth' => [
                'user' => $user
            ],
            'bookings' => $bookings,
        ]);
    }
}
