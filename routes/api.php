<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;

Route::prefix('dev')->middleware('api')->middleware('auth.token')->group(function () {
    Route::post('/ping', [TestController::class, 'ping']);
});

Route::prefix('user')->middleware('api')->middleware('auth.token')->group(function () {
    Route::post('/create', [UserController::class, 'createUser']);
    /* Route::post('/update', [UserController::class, 'updateUser']);
    Route::post('/delete', [UserController::class, 'deleteUser']); */
    Route::post('/login', [UserController::class, 'loginUser']);
    Route::post('/get', [UserController::class, 'getUser']);
});
