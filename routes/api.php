<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

require __DIR__.'/userapi.php';

Route::middleware('auth:sanctum')->group(function () {
    // Resource routes for court schedules
    Route::apiResource('court-schedules', CourtScheduleController::class);
});