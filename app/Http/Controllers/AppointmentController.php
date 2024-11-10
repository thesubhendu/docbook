<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->user_type === 'patient') {
            return auth()->user()->patient->appointments;
        }

        return AppointmentResource::collection(auth()->user()->doctor->appointments);
    }

}
