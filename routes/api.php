<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\Api\UserController;

Route::post('/register', [UserController::class, 'register']);   // Registration
Route::post('/login', [UserController::class, 'login']);         // Login

// Protected routes (Sanctum authentication required)
Route::middleware('auth:sanctum')->group(function () {

    // All CRUD user routes (index, store, show, update, delete)
    Route::apiResource('users', UserController::class);

    // Logout endpoint
    Route::post('/logout', [UserController::class, 'logout']);
});
