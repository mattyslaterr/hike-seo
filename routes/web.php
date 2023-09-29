<?php

use App\Http\Controllers\ProfileController;
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

// Homepage / booking form
Route::get('/', function () {
    return view('home');
})->name('homepage');

// Display users bookings
Route::get('/my-bookings', function () {
    return view('my-bookings');
});

// Admin panel / profile
Route::prefix('admin')->middleware('auth')->group(function () {

    // View bookings
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Blocked bookings
    Route::get('/blocked-bookings', function () {
        return view('blocked-bookings');
    })->name('blocked-bookings');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
