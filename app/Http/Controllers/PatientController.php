<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;

class PatientController extends Controller
{

    public function store(StorePatientRequest $request)
    {
        if ($request->user()->cannot('create', Patient::class)) {
            return response()->json(['message'=>'Unauthorized'], 403);
        }

        $patient = $request->user()->patient()->firstOrCreate(['user_id'=>auth()->id()], $request->validated());

        return (new PatientResource($patient))->additional(['message'=>'Patient Created Successfully']);
    }

    public function update(StorePatientRequest $request)
    {
        $patient = $request->user()->patient;
        $patient->update($request->validated());

        return (new PatientResource($patient))->additional(['message'=>'Patient Updated Successfully']);
    }

    public function show()
    {
        $patient = auth()->user()->patient;
        return (new PatientResource($patient))->additional(['message'=>'Patient Updated Successfully']);
    }

    public function destroy()
    {
        $patient = auth()->user()->patient;
        $patient->delete();

        return response()->json(['message'=>'Patient Deleted Successfully']);
    }
}
