<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Flight;


class BookController extends Controller
{

    public function index($flightId)
    {
        $flight = Flight::findOrFail($flightId);

        return Inertia::render('Booking/Index', [
            'flight' => $flight, // This should be a Flight model or array with necessary data
        ]);

    }
}
