<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Doctor;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->filled('specialization_id')) {
            request()->validate(['specialization_id'=>'exists:specializations,id']);

            $doctors = Doctor::where('specialization_id', request('specialization_id'))->get();
        }else {
            $doctors = Doctor::all();
        }

        return $doctors;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDoctorRequest $request)
    {
        if($request->user()->cannot('create', Doctor::class)) {
            return response()->json(['message'=>'Unauthorized'], 403);
        }

        $request->user()->doctor()->firstOrCreate(['user_id'=>auth()->id()],$request->validated());

        return response()->json(['message'=>'Doctor Created'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        return response()->json(['doctor'=> $doctor->load('schedules')]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        if($request->user()->cannot('update', $doctor)) {
            return response()->json(['message'=>'Unauthorized'], 403);
        }

        $doctor->update($request->validated());

        return response()->json(['message'=>'Doctor Updated'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        if(auth()->user()->cannot('delete', $doctor)) {
            return response()->json(['message'=>'Unauthorized'], 403);
        }

        $doctor->delete();
        return response()->json(['message'=>'Doctor Deleted'], 201);
    }
}
