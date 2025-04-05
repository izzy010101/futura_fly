<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

class FlightController extends Controller
{
    // home page logic search
    public function index(Request $request)
    {
        $query = Flight::query();

        if ($request->filled('departure')) {
            $departure = trim(strtolower($request->departure));
            $query->whereRaw("LOWER(TRIM(`departure`)) = ?", [$departure]);
        }

        if ($request->filled('destination')) {
            $destination = trim(strtolower($request->destination));
            $query->whereRaw("LOWER(TRIM(`destination`)) = ?", [$destination]);
        }

        $flights = $query->orderBy('departure_time')->get();

        return Inertia::render('Home', [
            'flights' => $flights,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'filters' => $request->only(['departure', 'destination']),
            'canBook' => auth()->check(),
        ]);
    }

    // explore page available flights
    public function explore()
    {
        $flights = Flight::orderBy('departure_time')->get();

        return Inertia::render('Explore', [
            'flights' => $flights,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'canBook' => auth()->check(),
        ]);
    }
}
