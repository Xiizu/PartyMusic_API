<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\MusicController;

Route::prefix('dev')->middleware('api')->middleware('auth.token')->group(function () {
    Route::post('/ping', [TestController::class, 'ping']);
});

Route::prefix('user')->middleware('api')->middleware('auth.token')->group(function () {
    Route::post('/create', [UserController::class, 'createUser']);
    /* Route::post('/update', [UserController::class, 'updateUser']);
    Route::post('/delete', [UserController::class, 'deleteUser']); */
    Route::post('/login', [UserController::class, 'loginUser']);
    Route::post('/get', [UserController::class, 'getUser']);
    Route::post('/changeUsername', [UserController::class, 'changeUsername']);
    Route::post('/changePassword', [UserController::class, 'changePassword']);
});

Route::prefix('room')->middleware('api')->middleware('auth.token')->group(function () {
    Route::post('/create', [RoomController::class, 'createRoom']);
   /*  Route::post('/update', [RoomController::class, 'updateRoom']);
    Route::post('/delete', [RoomController::class, 'deleteRoom']);*/
    Route::post('/get', [RoomController::class, 'getRoom']); 
    Route::post('/join', [RoomController::class, 'joinRoom']);
});

Route::prefix('music')->middleware('api')->middleware('auth.token')->group(function () {
    /* Route::post('/create', [MusicController::class, 'createMusic']); */
    /* Route::post('/update', [MusicController::class, 'updateMusic']);
    Route::post('/delete', [MusicController::class, 'deleteMusic']); */
    Route::post('/create', [MusicController::class, 'createMusic']);
    Route::post('/get', [MusicController::class, 'getMusic']);
    Route::post('/all', [MusicController::class, 'getAllMusicForUser']);
    /* Route::post('/getAudio', [MusicController::class, 'extractAudioUrl']); */
});