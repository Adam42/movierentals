<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\OrderController;

Route::prefix('v1')->group(function () {

    Route::post('/orders', [OrderController::class, 'store']);

    Route::apiResource('movies', MovieController::class);
});
