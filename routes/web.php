<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\PageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\PrivilegeClubController;



//image setup
Route::post('/upload-image', [ImageUploadController::class, 'store'])->name('image.upload');

Route::get('/upload-image-form', function () {
    return Inertia::render('UploadImage');
});

//flights
Route::get('/', [FlightController::class, 'index'])->name('home');
Route::get('/explore', [FlightController::class, 'explore'])->name('explore');


//static pages from home page
Route::get('/offers', [OffersController::class, 'index'])->name('offers');

//spring offers 12% discount, ovde dodati logiku da izracuna 12 posto kad odem na book this flight
Route::get('/springoffers', [OffersController::class, 'spring'])->name('springoffers');

//stopover, addons, checkout
Route::get('/stopover', [PageController::class, 'stopover'])->name('stopover');
Route::get('/addons', [PageController::class, 'addons'])->name('addons');




// Destination: New York
Route::get('/destinations/new-york', function () {
    return Inertia::render('Destinations/NewYork', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('destinations.newyork');

// Destination: Berlin
Route::get('/destinations/berlin', function () {
    return Inertia::render('Destinations/Berlin', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('destinations.berlin');

//Destionation:Tokyo

Route::get('/destinations/tokyo', function () {
    return Inertia::render('Destinations/Tokyo', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('destinations.tokyo');

Route::get('/destinations', [PageController::class, 'destinations'])->name('destinations');



//newsletter footer, for now just putting emails in db
Route::post('/subscribe', [NewsletterController::class, 'subscribe']);


//contact, faq, policies and travel_alerts pages in footer
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/alerts', [PageController::class, 'alerts'])->name('alerts');
Route::get('/policies', [PageController::class, 'policies'])->name('policies');


////custom AJAX route used for live email validation
Route::post('/validate-email', function (Request $request) {
    $exists = User::where('email', $request->email)->exists();
    return response()->json(['exists' => $exists]);
})->name('custom.verification.notice');

Route::post('/reset-password', [AuthenticatedSessionController::class, 'store'])
    ->name('password.store');


//logged in user routes
Route::middleware('auth')->group(function () {
//    profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//    booking routes
    Route::get('/booking/{flight}', [BookController::class, 'index'])->name('booking.index');
    Route::post('/booking', [BookController::class, 'store'])->name('booking.store');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::delete('/booking/{booking}', [BookController::class, 'destroy'])->name('booking.cancel');
    Route::get('/booking/checkout/{booking}', [BookController::class, 'checkout'])->name('booking.checkout');

//    privilege routes
    Route::get('/privilege', [PrivilegeClubController::class, 'index'])->name('privilege.index');
});



require __DIR__.'/auth.php';
