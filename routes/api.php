<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CitaController;
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas con token
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/usuario', [AuthController::class, 'usuario']);
});