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
        ]);

        // Find the flight and calculate the price (apply any discount logic here)
        $flight = Flight::findOrFail($validated['flight_id']);
        $discountedPrice = $flight->price;

        // Create the booking
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'flight_id' => $flight->id,
            'price' => $discountedPrice,
        ]);

        // Set the working directory to the blockchain folder and deploy the smart contract
        $process = new Process(['npx', 'hardhat', 'run', 'scripts/deploy.js', '--network', 'apex']);
        $process->setWorkingDirectory(base_path('blockchain')); // Make sure the 'blockchain' folder is specified correctly
        $process->run();

        // Check if the process ran successfully
//        if (!$process->isSuccessful()) {
//            throw new ProcessFailedException($process);
//        }

        // Extract the contract address from the output
        $output = $process->getOutput();
        $matches = [];
        preg_match('/0x[a-fA-F0-9]{40}/', $output, $matches);
        $deployedAddress = $matches[0] ?? null;



        // If the contract address is found, save it in the booking record
        if ($deployedAddress) {
            $booking->escrow_contract_address = $deployedAddress;
            $booking->save();
        } else {
            // If no contract address is found, handle the error appropriately
            return redirect()->route('dashboard')->with('error', 'Contract address not found!');
        }

        // Redirect to the dashboard with a success message
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
