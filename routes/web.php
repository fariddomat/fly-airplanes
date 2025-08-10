<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard\ImageGalleryController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/clear', function () {

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');

    return "Cleared!";
});
Route::get('/', [SiteController::class, 'home'])->name('home');

Route::get('/flights/search', [SiteController::class, 'showFlightSearch'])->name('flights.search');
Route::post('/flights/search', [SiteController::class, 'searchFlights'])->name('flights.search');
Route::post('/flights/book', [SiteController::class, 'bookFlight'])->name('flights.book');


Route::get('/cars/search',  [SiteController::class, 'showCarSearch'])->name('cars.search');
Route::post('/cars/search',  [SiteController::class, 'searchCars'])->name('cars.search');
Route::post('/cars/book', [SiteController::class, 'bookCar'])->middleware('auth')->name('cars.book');

// Hotel Routes
Route::get('/hotels/search', [SiteController::class, 'showHotelSearch'])->name('hotels.search');
Route::post('/hotels/search', [SiteController::class, 'searchHotels'])->name('hotels.search');
Route::post('/hotels/book', [SiteController::class, 'bookHotel'])->middleware('auth')->name('hotels.book');

Route::middleware(['web'])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->middleware(['auth', 'verified'])
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->middleware(['auth'])
        ->name('profile');
});

Route::prefix('dashboard')
    ->name('dashboard.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::middleware(['role:superadministrator'])->group(function () {
        Route::resource('users', UserController::class);
        });
Route::middleware(['role:administrator|superadministrator'])->group(function () {

        Route::resource('/airports', \App\Http\Controllers\Dashboard\AirportController::class);
        Route::post('/airports/{id}/restore', [\App\Http\Controllers\Dashboard\AirportController::class, 'restore'])->name('airports.restore');

        Route::resource('/airlines', \App\Http\Controllers\Dashboard\AirlineController::class);
        Route::post('/airlines/{id}/restore', [\App\Http\Controllers\Dashboard\AirlineController::class, 'restore'])->name('airlines.restore');

        Route::resource('/flights', \App\Http\Controllers\Dashboard\FlightController::class);
        Route::post('/flights/{id}/restore', [\App\Http\Controllers\Dashboard\FlightController::class, 'restore'])->name('flights.restore');

        Route::resource('/rentalcompanies', \App\Http\Controllers\Dashboard\RentalcompanyController::class);
        Route::post('/rentalcompanies/{id}/restore', [\App\Http\Controllers\Dashboard\RentalcompanyController::class, 'restore'])->name('rentalcompanies.restore');

        Route::resource('/cars', \App\Http\Controllers\Dashboard\CarController::class);
        Route::post('/cars/{id}/restore', [\App\Http\Controllers\Dashboard\CarController::class, 'restore'])->name('cars.restore');

        Route::resource('/hotels', \App\Http\Controllers\Dashboard\HotelController::class);
        Route::post('/hotels/{id}/restore', [\App\Http\Controllers\Dashboard\HotelController::class, 'restore'])->name('hotels.restore');

        Route::resource('/adds', \App\Http\Controllers\Dashboard\AddController::class);
        Route::post('/adds/{id}/restore', [\App\Http\Controllers\Dashboard\AddController::class, 'restore'])->name('adds.restore');

});


        Route::resource('/bookings', \App\Http\Controllers\Dashboard\BookingController::class);
        Route::post('/bookings/{id}/restore', [\App\Http\Controllers\Dashboard\BookingController::class, 'restore'])->name('bookings.restore');

        Route::resource('/carrentals', \App\Http\Controllers\Dashboard\CarrentalController::class);
        Route::post('/carrentals/{id}/restore', [\App\Http\Controllers\Dashboard\CarrentalController::class, 'restore'])->name('carrentals.restore');


        Route::resource('/hotelbookings', \App\Http\Controllers\Dashboard\HotelbookingController::class);
        Route::post('/hotelbookings/{id}/restore', [\App\Http\Controllers\Dashboard\HotelbookingController::class, 'restore'])->name('hotelbookings.restore');
 });


require __DIR__ . '/auth.php';
