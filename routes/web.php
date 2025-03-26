<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Inertia\Inertia;

use App\Http\Controllers\FlightController;
use App\Http\Controllers\ProfileController;

Route::get('/', [FlightController::class, 'index'])->name('home'); // ✅ Home page with search + flights

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/explore', function () {
    return Inertia::render('Explore');
})->name('explore');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/book-flight', fn () => Inertia::render('BookFlight'))->name('book');
Route::get('/checkout', fn () => Inertia::render('Checkout'))->name('checkout');

require __DIR__.'/auth.php';
