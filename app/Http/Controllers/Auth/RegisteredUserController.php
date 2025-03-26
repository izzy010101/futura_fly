<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return inertia('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'phone:' . $request->country],
            'country' => ['required', 'string', 'size:2'],
            'passport_number' => ['required', 'string', 'regex:/^[A-Z0-9]{6,12}$/'],
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'phone.phone' => 'The phone number is invalid for the selected country.',
            'passport_number.regex' => 'The passport number format is invalid (6-12 alphanumeric uppercase characters).',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => phone($request->phone, $request->country)->formatE164(),
            'passport_number' => strtoupper($request->passport_number),
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
