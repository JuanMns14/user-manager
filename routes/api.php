<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// CRUD routes
Route::prefix('v1')->group(function () {
    //Public routes
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}', [UserController::class, 'show']);

    //Protected routes-Only
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users{user}', [UserController::class, 'update']);
        Route::delete('/users/{user}', [UserController::class, 'destroy']);
    });
});
