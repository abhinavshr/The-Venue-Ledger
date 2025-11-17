<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourtScheduleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

require __DIR__.'/userapi.php';
require __DIR__.'/futsalOwnerApi.php';
require __DIR__.'/superadmin.php';
require __DIR__.'/authapi.php';

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('court-schedules', CourtScheduleController::class);
});
