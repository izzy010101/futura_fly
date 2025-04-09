<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\Booking;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Flight;


class BookController extends Controller
{

    public function index(Flight $flight)
    {
        $addons = Addon::all(['id', 'name', 'description', 'price', 'unit']);

        return Inertia::render('Booking/Index', [
            'flight' => $flight,
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

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'flight_id' => $validated['flight_id'],
        ]);

        if (!empty($validated['addons'])) {
            $booking->addons()->attach($validated['addons']);
        }
        return redirect()->route('dashboard')->with('success', 'Booking completed successfully!');
    }

}
