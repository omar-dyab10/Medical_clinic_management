<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AvailableDayController;
use App\Http\Controllers\Doctors\DoctorController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('users', UserController::class)->middleware(['auth:sanctum', 'is_admin']);
Route::apiResource('doctors', DoctorController::class);
Route::apiResource('available-days', AvailableDayController::class)->middleware(['auth:sanctum', 'is_doctor']);
