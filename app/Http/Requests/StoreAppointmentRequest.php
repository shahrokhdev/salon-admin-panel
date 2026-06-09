<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'service_id' => ['required', 'exists:services,id'],
            'barber_id' => ['nullable', 'exists:barbers,id'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['required', 'date_format:H:i'],
            'status' => ['required', Rule::in(['pending', 'confirmed', 'completed', 'cancelled'])],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'The customer field is required.',
            'service_id.required' => 'The service field is required.',
            'date.required' => 'The appointment date is required.',
            'date.after_or_equal' => 'The appointment date must be today or later.',
            'time.required' => 'The appointment time is required.',
        ];
    }
}
