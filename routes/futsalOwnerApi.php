<?php

use App\Http\Controllers\Api\FutsalOwner\CourtController;
use Illuminate\Support\Facades\Route;

Route::prefix('futsal-owner')->middleware('auth:sanctum')->group(function () {
    Route::get('/getcourts', [CourtController::class, 'index']);
    Route::post('/registercourts', [CourtController::class, 'store']);
    Route::get('/getcourt/{id}', [CourtController::class, 'show']);
    Route::put('/updatecourt/{id}', [CourtController::class, 'update']);
    Route::delete('/deletecourt/{id}', [CourtController::class, 'destroy']);
});

