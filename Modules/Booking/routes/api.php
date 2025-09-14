<?php

use Illuminate\Support\Facades\Route;
use Modules\Booking\Http\Controllers\Api\V1\BookingController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('bookings', BookingController::class)->names('booking');
});
