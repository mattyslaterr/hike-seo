<?php

use App\Http\Controllers\Api\BlockedBookingController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Middleware\Admin;
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

    // Get blocked timeslots for bookings endpoint
    Route::get('blocked', [BookingController::class, 'blocked']);

    // Get all bookings endpoint
    Route::get('all', [BookingController::class, 'show']);
});

// Blocked bookings endpoints
Route::prefix('blocked-bookings')->group(function() {

    // Get all blocked bookings endpoint
    Route::get('all', [BlockedBookingController::class, 'show']);

    // Add blocked bookings endpoint
    Route::post('add', [BlockedBookingController::class, 'add']);

    // Remove blocked bookings endpoint
    Route::post('remove', [BlockedBookingController::class, 'remove']);
});
