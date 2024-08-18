<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->doctor){
            return auth()->user()->doctor->schedules()->get();
        }

        return response()->json(['message'=>'Schedule Not Found'], 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScheduleRequest $request)
    {
        auth()->user()->doctor->schedules()->firstOrCreate(['available_from' => $request->available_from,'available_to' => $request->available_to, 'day_of_week' => $request->day_of_week],$request->validated());

        return response()->json(['message'=>'Schedule Created'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        return response()->json(['schedule'=> $schedule]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        $schedule->update($request->validated());

        return response()->json(['message'=>'Schedule Updated'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return response()->json(['message'=>'Schedule Deleted'], 201);
    }
}
