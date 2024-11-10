<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BookAppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SearchDoctorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


require __DIR__ . '/auth.php';

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::middleware('can:doctor')->group(function () {
        Route::get('doctors', [DoctorController::class, 'show']);
        Route::post('doctors', [DoctorController::class, 'store']);
        Route::put('doctors', [DoctorController::class, 'update']);
        Route::delete('doctors', [DoctorController::class, 'destroy']);
    });

    Route::middleware('can:patient')->group(function () {
        Route::get('search-doctors', SearchDoctorController::class);

        Route::get('patients', [PatientController::class, 'show']);
        Route::post('patients', [PatientController::class, 'store']);
        Route::put('patients', [PatientController::class, 'update']);
        Route::delete('patients', [PatientController::class, 'destroy']);

        Route::post('book', BookAppointmentController::class);
    });

    Route::get('appointments', AppointmentController::class);
});
