<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\PageController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ImageUploadController;


//image setup

Route::post('/upload-image', [ImageUploadController::class, 'store'])->name('image.upload');

Route::get('/upload-image-form', function () {
    return Inertia::render('UploadImage');
});



Route::get('/', [FlightController::class, 'index'])->name('home');
Route::get('/explore', [FlightController::class, 'explore'])->name('explore');

//static pages from home page

Route::get('/offers', [OffersController::class, 'index'])->name('offers');

Route::get('/stopover', function () {
    return Inertia::render('Stopover', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('stopover');

//spring offers 12% discount
Route::get('/springoffers', [OffersController::class, 'spring'])->name('springoffers');

//adds on
Route::get('/addons', function () {
    return Inertia::render('AddOns', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('addons');

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

Route::get('/destinations/tokyo', function () {
    return Inertia::render('Destinations/Tokyo', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('destinations.tokyo');

Route::get('/destinations', [PageController::class, 'destinations'])->name('destinations');



//newsletter footer
Route::post('/subscribe', [NewsletterController::class, 'subscribe']);


//contact, faq, policies and travelalerts pages in footer
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/alerts', [PageController::class, 'alerts'])->name('alerts');
Route::get('/policies', [PageController::class, 'policies'])->name('policies');


Route::post('/validate-email', function (\Illuminate\Http\Request $request) {
    $exists = User::where('email', $request->email)->exists();
    return response()->json(['exists' => $exists]);
});

Route::post('/reset-password', [AuthenticatedSessionController::class, 'store'])
    ->name('password.store');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//    booking routes
    Route::get('/booking/{flight}', [BookController::class, 'index'])->name('booking.index');
    Route::post('/booking', [BookController::class, 'store'])->name('booking.store');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


});


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
