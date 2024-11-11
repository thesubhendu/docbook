<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Doctor;
use Carbon\Carbon;

class AppointmentService
{
    public function __construct()
    {
    }

    public function isAppointmentAvailable(int $doctorId, string $appointmentDateTime): bool
    {
        $appointmentDateTime = Carbon::parse($appointmentDateTime);
        $doctor = Doctor::find($doctorId);

        // check if doctor's schedule exists on the day of week
        if (!array_key_exists($appointmentDateTime->dayName, $doctor->availability)) {
            return false;
        }

        // checking if doctor is on leave
        if (array_key_exists($appointmentDateTime->toDateString(), $doctor->exceptions)) {
            $dayOff = $doctor->exceptions[$appointmentDateTime->toDateString()];
            if ($dayOff == null) {
                return false;
            }

            foreach ($dayOff as $schedule) {
                [$from, $to] = explode('-', $schedule);
                $fromTime = $appointmentDateTime->copy()->setTimeFromTimeString($from);
                $toTime = $appointmentDateTime->copy()->setTimeFromTimeString($to);
                if ($appointmentDateTime->between($fromTime, $toTime)) {
                    return false;
                }
            }
        }

        $doctorSchedule = $doctor->availability[$appointmentDateTime->dayName];

        foreach ($doctorSchedule as $schedule) {
            [$from, $to] = explode('-', $schedule);
            $fromTime = $appointmentDateTime->copy()->setTimeFromTimeString($from);
            $toTime = $appointmentDateTime->copy()->setTimeFromTimeString($to);
            if ($appointmentDateTime->between($fromTime, $toTime)) {
                // Checking if the slot is already booked
                $isSlotBooked = Appointment::where('doctor_id', $doctor->id)
                    ->where('appointment_date', $appointmentDateTime)
                    ->exists();

                if ($isSlotBooked) {
                    return false;
                }
                return true;
            }
        }

        return false;
    }

}
