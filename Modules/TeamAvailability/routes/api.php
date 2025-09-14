<?php

use Illuminate\Support\Facades\Route;
use Modules\TeamAvailability\Http\Controllers\TeamAvailabilityController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::post('teams/{team}/availability', [TeamAvailabilityController::class, 'store']);
});
