<?php

use Illuminate\Support\Facades\Route;
use Modules\TeamAvailability\Http\Controllers\TeamAvailabilityController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('teamavailabilities', TeamAvailabilityController::class)->names('teamavailability');
});
