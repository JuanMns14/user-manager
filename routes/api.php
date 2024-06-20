<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\OpenAI\GenerateTextController;
use App\Http\Controllers\API\Strapi\CommentController;
use App\Http\Controllers\API\Strapi\PostController;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

// API
Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function () {
    // CRUD Routes
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{user}', [UserController::class, 'show']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{user}', [UserController::class, 'update']);
        Route::delete('/{user}', [UserController::class, 'destroy']);
    });
    // AI Routes
    Route::prefix('ai')->group(function () {
        Route::post('/generate-text', [GenerateTextController::class, 'generateText']);
    });
    // Strapi Routes
    Route::prefix('strapi')->group(function () {
        Route::prefix('posts')->group(function () {
            Route::get('/', [PostController::class, 'index']);
            Route::get('/{post}', [PostController::class, 'show']);
        });
        Route::prefix('comments')->group(function () {
            Route::get('/', [CommentController::class, 'index']);
            Route::get('/{comment}', [CommentController::class, 'show']);
        });
    });
});
