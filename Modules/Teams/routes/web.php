<?php

use Illuminate\Support\Facades\Route;
use Modules\Teams\Http\Controllers\Api\V1\Teams\TeamsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('teams', TeamsController::class)->names('teams');
});
