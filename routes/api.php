<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum','verified'])->get('/user', function (Request $request) {
    return $request->user();
});


require __DIR__.'/auth.php';

//Doctor api routes

// doctor

Route::apiResource('doctors',DoctorController::class)->middleware(['auth:sanctum']);
Route::apiResource('patients',\App\Http\Controllers\PatientController::class)->middleware(['auth:sanctum']);
Route::apiResource('schedules', ScheduleController::class)->middleware(['auth:sanctum']);
Route::apiResource('appointments', AppointmentController::class)->middleware(['auth:sanctum']);
