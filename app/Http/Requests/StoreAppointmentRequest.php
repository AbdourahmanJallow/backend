<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'doctor_id' => ['bail', 'required', 'exists:doctors,id'],
            // 'patient_id' => ['required', 'exists:patients,id'],
            // 'scheduled_at' => ['required', 'date_format:Y-m-d H:i:s'],
            'reasons' => ['required', 'max:500']
        ];
    }

    public function messages()
    {
        return [
            'reasons.required' => 'Reasons requied for',
        ];
    }
}
