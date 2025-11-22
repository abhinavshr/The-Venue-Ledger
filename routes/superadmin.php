<?php

use App\Http\Controllers\Api\SuperAdmin\FutsalOwnerVerification;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::put('/superadmin/futsal-venues/{id}/verify', [FutsalOwnerVerification::class, 'updateVerification']);
});
