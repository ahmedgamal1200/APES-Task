<?php

use Illuminate\Support\Facades\Route;
use Modules\TeamAvailability\Http\Controllers\TeamAvailabilityController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('teamavailabilities', TeamAvailabilityController::class)->names('teamavailability');
});
