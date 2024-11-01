<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BookAppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


require __DIR__.'/auth.php';

//Doctor api routes

// doctor

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::apiResource('doctors',DoctorController::class);
    Route::apiResource('patients', PatientController::class);
    Route::apiResource('schedules', ScheduleController::class);
    Route::apiResource('appointments', AppointmentController::class)->only('index');

    Route::post('book', BookAppointmentController::class);
});
