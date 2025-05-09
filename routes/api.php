<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AvailableDayController;
use App\Http\Controllers\Doctors\DoctorController;
use App\Http\Controllers\BookingController;

use App\Http\Controllers\TimeSlotController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('users', UserController::class)->middleware(['auth:sanctum', 'is_admin']);
Route::apiResource('doctors', DoctorController::class)->only(['index','show'])->middleware('auth:sanctum');
Route::apiResource('available-days', AvailableDayController::class)->middleware(['auth:sanctum', 'is_doctor']);


Route::apiResource('bookings', BookingController::class);

Route::apiResource('time-slots', TimeSlotController::class)->middleware(['auth:sanctum', 'is_doctor']);
