<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Booking\BookingController;

Route::prefix('bookings')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [BookingController::class, 'store']);
});