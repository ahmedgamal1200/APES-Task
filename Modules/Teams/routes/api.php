<?php

use Illuminate\Support\Facades\Route;
use Modules\Teams\Http\Controllers\Api\V1\Teams\GenerateSlotController;
use Modules\Teams\Http\Controllers\Api\V1\Teams\TeamsController;

Route::middleware(['auth:sanctum', 'role:admin'])->prefix('v1')->group(function () {
    Route::apiResource('teams', TeamsController::class)->names('teams');
    Route::get('teams/{team}/generate-slots', [GenerateSlotController::class, 'generateSlots']);
});
