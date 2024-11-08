<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'doctor_id' => ['required', 'exists:doctors,id'],
            'appointment_date' => ['required', 'date_format:Y-m-d H:i'],
            'reason' => [ 'string', 'max:255'],
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $appointmentDateTime = Carbon::parse($this->appointment_date);

            // Validate if the appointment time is in 15-minute intervals
            if ($appointmentDateTime->minute % 15 !== 0) {
                $validator->errors()->add('appointment_datetime', 'The appointment time must be in 15-minute intervals (e.g., 9:00, 9:15, 9:30).');
            }
        });
    }
}
