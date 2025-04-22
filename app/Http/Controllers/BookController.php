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

        // Apply 12% spring discount if applicable
        $price = $flight->price;
        if ($flight->departure_time && Carbon::parse($flight->departure_time)->isBetween('2025-03-01', '2025-05-31')) {
            $price = round($flight->price * 0.88, 2);
        }

        // Add cost of selected add-ons
        $addonTotal = 0;
        if (!empty($validated['addons'])) {
            $addonTotal = Addon::whereIn('id', $validated['addons'])->sum('price');
        }

        $totalPrice = round($price + $addonTotal, 2);

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'flight_id' => $flight->id,
            'price' => $totalPrice,
        ]);

        if (!empty($validated['addons'])) {
            $booking->addons()->attach($validated['addons']);
        }

        return redirect()->route('dashboard')->with('success', 'Booking completed successfully!');
    }




}
