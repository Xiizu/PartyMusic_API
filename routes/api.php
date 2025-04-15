<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

Route::prefix('dev')->middleware('api')->middleware('auth.token')->group(function () {
    Route::post('/ping', [TestController::class, 'ping']);
});
