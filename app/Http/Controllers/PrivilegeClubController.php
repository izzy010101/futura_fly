<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\PrivilegeLog;

class PrivilegeClubController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $totalPoints = $user->privilegeLogs()->sum('points');

        $tier = match (true) {
            $totalPoints >= 30000 => 'Platinum',
            $totalPoints >= 10000 => 'Gold',
            default => 'Silver',
        };

        return Inertia::render('Privilege/Index', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'points' => $totalPoints,
                'tier' => $tier,
            ],
        ]);
    }

}

