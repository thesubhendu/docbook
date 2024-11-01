<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;

class BookAppointmentController extends Controller
{
    public function __invoke(StoreAppointmentRequest $request)
    {
        if($request->user()->cannot('create', Appointment::class)){
            return response()->json('Unauthorized', 403);
        }

        $data = $request->validated();
        $data['status'] = 'completed';

        $request->user()->patient->appointments()->create($data);

        return response()->json(['message'=>'Appointment Created'], 201);
    }
}
