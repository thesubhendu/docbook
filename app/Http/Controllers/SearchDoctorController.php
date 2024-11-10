<?php

namespace App\Http\Controllers;

use App\Http\Resources\DoctorResource;
use App\Models\Doctor;

class SearchDoctorController extends Controller
{
    public function __invoke()
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
}
