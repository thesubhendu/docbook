<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
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

        return auth()->user()->doctor->appointments;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
        if($request->user()->cannot('create', Appointment::class)){
            return response()->json('Unauthorized', 403);
        }

        $data = $request->validated();
        $data['status'] = 'completed';

        $request->user()->patient->appointments()->create($data);

        return response()->json(['message'=>'Appointment Created'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
