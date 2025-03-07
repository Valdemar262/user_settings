<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\VerificationController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/settings/update', [SettingsController::class, 'update']);

    Route::get('/verification/methods', [VerificationController::class, 'getMethods']);

    Route::post('/verification/request', [VerificationController::class, 'requestCode']);

    Route::post('/verification/verify', [VerificationController::class, 'verify']);
});
