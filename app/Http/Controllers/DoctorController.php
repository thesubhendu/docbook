<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDoctorRequest;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use Gate;
use Illuminate\Http\Response;

class DoctorController extends Controller
{

    public function index()
    {
        $query = Doctor::query()->with('user');

        if (request()->filled('specialization_id')) {
            request()->validate(['specialization_id'=>'exists:specializations,id']);
            $doctors = $query->where('specialization_id', request('specialization_id'))->get();
        } else {
            $doctors = $query->get();
        }

        return  DoctorResource::collection($doctors)
            ->additional(['message'=>'Retrieved Successfully'])
            ;
    }

    public function store(StoreDoctorRequest $request)
    {
        Gate::authorize('create', Doctor::class);

        $doctor = $request->user()->doctor()->firstOrCreate(['user_id'=>auth()->id()], $request->validated());

        return (new DoctorResource($doctor))
            ->additional(['message'=>'Created Successfully'])
            ->response()
            ->setStatusCode(Response::HTTP_CREATED)
            ;
    }

    public function show(Doctor $doctor)
    {
        return new DoctorResource($doctor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDoctorRequest $request, Doctor $doctor)
    {
        Gate::authorize('update', $doctor);

         $doctor->update($request->validated());

        return (new DoctorResource($doctor))
        ->additional(['message'=>'Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        Gate::authorize('delete', $doctor);

        $doctor->delete();

        return response()->json(['message'=>'Doctor Deleted']);
    }
}
