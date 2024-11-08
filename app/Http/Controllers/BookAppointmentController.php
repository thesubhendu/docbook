<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Services\AppointmentService;
use Carbon\Carbon;

class BookAppointmentController extends Controller
{
    public function __construct(
        private AppointmentService $appointmentService
    )
    {
    }

    public function __invoke(StoreAppointmentRequest $request)
    {
        if ($request->user()->cannot('create', Appointment::class)) {
            return response()->json('Please complete patient profile before booking', 403);
        }

        $data = $request->validated();

        // check if appointment date is withing doctors schedule and is not already booked
        $doctor = $data['doctor_id'];

        if (!$this->appointmentService->isAppointmentAvailable($doctor, $data['appointment_date'])) {
            return response()->json('Please select available slot', 403);
        }

        $data['status'] = 'completed';

        $request->user()->patient->appointments()->create($data);

        return response()->json(['message' => 'Appointment Created'], 201);
    }

}
