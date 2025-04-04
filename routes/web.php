<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\OffersController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\ProfileController;

Route::get('/', [FlightController::class, 'index'])->name('home');
Route::get('/explore', [FlightController::class, 'explore'])->name('explore');

//static pages from home page

Route::get('/offers', [OffersController::class, 'index'])->name('offers');



Route::post('/validate-email', function (\Illuminate\Http\Request $request) {
    $exists = User::where('email', $request->email)->exists();
    return response()->json(['exists' => $exists]);
});

Route::post('/reset-password', [AuthenticatedSessionController::class, 'store'])
    ->name('password.store');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Route::get('/explore', function () {
//    return Inertia::render('Explore');
//})->name('explore');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/book-flight', fn () => Inertia::render('BookFlight'))->name('book');
Route::get('/checkout', fn () => Inertia::render('Checkout'))->name('checkout');


Route::get('/email/verify', function () {
    return Inertia::render('Auth/VerifyEmail');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard'); // or wherever you want
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

require __DIR__.'/auth.php';
