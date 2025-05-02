<?php

namespace App\Http\Controllers;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Models\Addon;
use App\Models\Booking;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Flight;
use Carbon\Carbon;
use App\Models\PrivilegeLog;



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

    // Controller method where the escrow contract address is saved
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'flight_id' => 'required|exists:flights,id',
            'addons' => 'nullable|array',
            'addons.*' => 'integer|exists:addons,id',
            'is_spring_offer' => 'nullable|boolean',
        ]);

        // Find the selected flight
        $flight = Flight::findOrFail($validated['flight_id']);

        // Determine the price based on is_spring_offer flag from frontend
        $discountedPrice = $flight->price;
        if (!empty($validated['is_spring_offer'])) {
            $discountedPrice = round($flight->price * 0.88, 2);
        }

        // Create the booking
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'flight_id' => $flight->id,
            'price' => $discountedPrice,
        ]);

        // Attach addons if provided
        if (!empty($validated['addons'])) {
            $booking->addons()->attach($validated['addons']);
        }

        // Privilege Club: Award points to the user
        $multiplier = match (auth()->user()->tier ?? 'Silver') {
            'Gold' => 1.5,
            'Platinum' => 2.0,
            default => 1.0,
        };

        $earnedPoints = floor($discountedPrice * $multiplier);

        \App\Models\PrivilegeLog::create([
            'user_id' => auth()->id(),
            'booking_id' => $booking->id,
            'points' => $earnedPoints,
            'type' => 'earned',
            'note' => 'Earned from booking flight #' . $flight->flight_number,
        ]);

        // Deploy Smart Contract for Escrow
        $process = new Process(['npx', 'hardhat', 'run', 'scripts/deploy.js', '--network', 'apex']);
        $process->setWorkingDirectory(base_path('blockchain'));
        $process->run();

        // Uncomment to throw an error if process fails
//    if (!$process->isSuccessful()) {
//        throw new \Symfony\Component\Process\Exception\ProcessFailedException($process);
//    }

        // Extract contract address from output
        $output = $process->getOutput();
        preg_match('/0x[a-fA-F0-9]{40}/', $output, $matches);
        $deployedAddress = $matches[0] ?? null;

        // Save contract address if valid
        if ($deployedAddress) {
            $booking->escrow_contract_address = $deployedAddress;
            $booking->save();
        } else {
            return redirect()->route('dashboard')->with('error', 'Contract address not found!');
        }

        return redirect()->route('dashboard')->with('success', 'Booking completed successfully!');
    }







    public function destroy(Booking $booking)
    {
        // 1. Ensure user owns the booking
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // 2. Find and reverse any points earned from this booking
        $earnedLog = PrivilegeLog::where('booking_id', $booking->id)
            ->where('user_id', auth()->id())
            ->where('type', 'earned')
            ->first();

        if ($earnedLog) {
            // Log the removal of points
            PrivilegeLog::create([
                'user_id' => auth()->id(),
                'booking_id' => $booking->id,
                'points' => -$earnedLog->points,
                'type' => 'removed',
                'note' => 'Points removed due to cancellation of flight #' . $booking->flight->flight_number,
            ]);
        }

        // 3. Cancel the booking
        $booking->delete();

        // 4. Refresh dashboard view
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
        // Ensure the contract address is in the data passed to the view
        return Inertia::render('Booking/Checkout', [
            'booking' => $booking->only([
                'id', 'price', 'escrow_contract_address', 'flight_id', 'created_at', 'updated_at'
            ]),
            'auth' => [
                'user' => auth()->user(),
            ],
        ]);
    }


}
