<?php

use Illuminate\Support\Facades\Route;
use Modules\Booking\Http\Controllers\Api\V1\BookingController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('bookings', BookingController::class)->names('booking');
});
