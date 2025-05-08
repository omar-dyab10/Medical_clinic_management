<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvailableDayRequest extends FormRequest
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
            'doctor_id' => 'required|exists:doctors,id',
            'available_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ];
    }
    public function messages(): array
    {
        return [
            'doctor_id.required' => 'The doctor field is required',
            'doctor_id.exists' => 'The doctor field must be an existing doctor',
            'day.required' => 'The day field is required',
            'start_time.required' => 'The start time field is required',
            'end_time.required' => 'The end time field is required',
        ];
    }
}