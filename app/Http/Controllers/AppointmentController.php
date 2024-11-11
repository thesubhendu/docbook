<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    /**
     * Show active appointments of the logged in user
     */
    public function __invoke()
    {
        $loggedInUserType =  auth()->user()->user_type;
        $loggedInUser = auth()->user();

        if ( $loggedInUserType === 'patient') {
            return AppointmentResource::collection($loggedInUser->patient->activeAppointments);
        }

        return AppointmentResource::collection($loggedInUser->doctor->activeAppointments);
    }

}
