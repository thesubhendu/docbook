<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Services\AppointmentService;

class BookAppointmentController extends Controller
{
    public function __construct(
        private readonly AppointmentService $appointmentService
    )
    {
    }

    public function __invoke(StoreAppointmentRequest $request)
    {
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
