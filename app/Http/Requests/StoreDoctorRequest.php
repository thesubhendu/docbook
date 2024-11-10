<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'specialization_id' => ['required', 'exists:specializations,id'],
            'bio' => [ 'string', 'max:255'],
            // Accepted JSON format for availability -> { "Monday": ["09:00-12:00", "14:00-18:00"], "Wednesday": ["10:00-13:00"] }
            'availability' => [
                'array',
                function ($attribute, $value, $fail) {
                    foreach ($value as $day => $slots) {
                        if (!in_array($day, ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'])) {
                            $fail('The '.$attribute.'.'.$day.' is not a valid day.');
                        }
                        foreach ($slots as $slot) {
                            if (!preg_match('/^([01]?[0-9]|2[0-3]):([0-5][0-9])\-([01]?[0-9]|2[0-3]):([0-5][0-9])$/', $slot)) {
                                $fail('The '.$attribute.'.'.$day.'.'.$slot.' is not a valid time slot.');
                            }
                        }
                    }
                },
            ],
            /* accepted format for exceptions
            {
                "2024-11-05": null, // Unavailable the entire day
                "2024-11-07": ["09:00-12:00"],     // Unavailable from 9 AM to 12 PM
                "2024-11-10": ["14:00-16:00"]      // Unavailable from 2 PM to 4 PM
            } */
            'exceptions' => [
                'array',
                function ($attribute, $value, $fail) {
                    foreach ($value as $date => $slots) {
                        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                            $fail('The '.$attribute.'.'.$date.' is not a valid date.');
                        }
                        if (is_array($slots)) {
                            foreach ($slots as $slot) {
                                if (!preg_match('/^([01]?[0-9]|2[0-3]):([0-5][0-9])\-([01]?[0-9]|2[0-3]):([0-5][0-9])$/', $slot)) {
                                    $fail('The '.$attribute.'.'.$date.'.'.$slot.' is not a valid time slot.');
                                }
                            }
                        }
                    }
                },
            ],
        ];
    }
}
