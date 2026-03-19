<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

          Route::post('/logout', [AuthController::class, 'logout']);

          Route::get('/user', [UserController::class, 'show']);
          Route::put('/user', [UserController::class, 'update']);
          Route::patch('/user', [UserController::class, 'update']);
          Route::delete('/user', [UserController::class, 'destroy']);

          Route::apiResource('urls', ShortUrlController::class);
});
