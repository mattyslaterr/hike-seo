<?php

use App\Http\Controllers\Api\BookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Booking form endpoints
Route::prefix('booking')->group(function() {

    // Submit customer booking from endpoint
    Route::post('submit', [BookingController::class, 'submit']);

    // Get customer bookings from email endpoint
    Route::get('my-bookings', [BookingController::class, 'get']);

    // Get blocked timeslots for bookings
    Route::get('blocked', [BookingController::class, 'blocked']);
});
