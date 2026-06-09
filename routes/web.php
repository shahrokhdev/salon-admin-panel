<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarberController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AvailabilitySlotController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Admin Dashboard
    Route::middleware('admin')->group(function () {
        Route::get('/admin', [DashboardController::class, 'index'])->name('dashboard');

        // User Management
        Route::resource('users', UserController::class);
        Route::get('/users/search', [UserController::class, 'search'])->name('users.search');

        // Barber Management
        Route::resource('barbers', BarberController::class);

        // Service Management
        Route::resource('services', ServiceController::class);

        // Appointment Management
        Route::resource('appointments', AppointmentController::class);
        Route::get('/appointments/filter/date', [AppointmentController::class, 'filterByDate'])->name('appointments.filterByDate');
        Route::get('/appointments/filter/status', [AppointmentController::class, 'filterByStatus'])->name('appointments.filterByStatus');

        // Availability Slots Management
        Route::resource('availability-slots', AvailabilitySlotController::class);
        Route::patch('/availability-slots/{availabilitySlot}/mark-as-booked', [AvailabilitySlotController::class, 'markAsBooked'])->name('availability-slots.markAsBooked');
        Route::patch('/availability-slots/{availabilitySlot}/mark-as-available', [AvailabilitySlotController::class, 'markAsAvailable'])->name('availability-slots.markAsAvailable');
    });
});

require __DIR__.'/auth.php';
