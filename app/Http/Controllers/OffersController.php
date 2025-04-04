<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Flight;

class OffersController extends Controller
{
    public function index()
    {
        $earlyBirds = Flight::where('first_minute', 1)
            ->orderBy('departure_time')
            ->take(6)
            ->get();

        $lastMinutes = Flight::where('last_minute', 1)
            ->orderBy('departure_time')
            ->take(6)
            ->get();

        return Inertia::render('Offers', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'earlyBirds' => $earlyBirds,
            'lastMinutes' => $lastMinutes,
        ]);
    }
}
