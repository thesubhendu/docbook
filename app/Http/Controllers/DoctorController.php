<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDoctorRequest;
use App\Http\Resources\DoctorResource;
use Illuminate\Http\Response;

class DoctorController extends Controller
{

    public function store(StoreDoctorRequest $request)
    {
        $doctor = $request->user()->doctor()->firstOrCreate(['user_id'=>auth()->id()], $request->validated());

        return (new DoctorResource($doctor))
            ->additional(['message'=>'Created Successfully'])
            ->response()
            ->setStatusCode(Response::HTTP_CREATED)
            ;
    }

    public function show()
    {
        return new DoctorResource(auth()->user()->doctor);
    }

    public function update(StoreDoctorRequest $request)
    {
        $doctor = $request->user()->doctor;

        $doctor->update($request->validated());

        return (new DoctorResource($doctor))
        ->additional(['message'=>'Updated Successfully']);
    }

    public function destroy()
    {
        auth()->user()->doctor->delete();
        return response()->json(['message'=>'Doctor Deleted']);
    }
}
