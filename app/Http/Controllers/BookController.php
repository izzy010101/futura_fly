<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\Booking;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Flight;
use Carbon\Carbon;




class BookController extends Controller
{

    public function index(Request $request, Flight $flight)
    {
        $addons = Addon::all(['id', 'name', 'description', 'price', 'unit']);

        $isSpringOffer = $request->query('spring') == '1';
        $now = Carbon::now();
        $discountedPrice = $flight->price;

        if ($isSpringOffer && $now->between(Carbon::parse('2025-03-01'), Carbon::parse('2025-05-31'))) {
            $discountedPrice = round($flight->price * 0.88, 2);
        }

        return Inertia::render('Booking/Index', [
            'flight' => [
                ...$flight->toArray(),
                'price' => $discountedPrice,
                'original_price' => $flight->price,
                'is_discounted' => $isSpringOffer,
            ],
            'addons' => $addons,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'flight_id' => 'required|exists:flights,id',
            'addons' => 'nullable|array',
            'addons.*' => 'integer|exists:addons,id',
        ]);

        $flight = Flight::findOrFail($validated['flight_id']);

        $discountedPrice = $flight->price;
        if ($flight->departure_time && \Carbon\Carbon::parse($flight->departure_time)->isBetween('2025-03-01', '2025-05-31')) {
            $discountedPrice = round($flight->price * 0.88, 2);
        }

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'flight_id' => $flight->id,
            'price' => $discountedPrice,
        ]);

        if (!empty($validated['addons'])) {
            $booking->addons()->attach($validated['addons']);
        }

        return redirect()->route('dashboard')->with('success', 'Booking completed successfully!');
    }


    public function destroy(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $booking->delete();

        // Return fresh Inertia response for dashboard
        $bookings = Booking::with(['flight', 'addons'])->where('user_id', auth()->id())->latest()->get();

        return Inertia::render('Dashboard', [
            'bookings' => $bookings,
            'auth' => [
                'user' => auth()->user(),
            ],
        ]);
    }


    public function checkout(Booking $booking)
    {
        return Inertia::render('Booking/Checkout', [
            'booking' => $booking,
            'auth' => [
                'user' => auth()->user()
            ],
        ]);
    }

}
