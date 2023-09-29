<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RemoveBlockedBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'date' => ['required', 'date'],
            'slot' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'date.required' => 'Booking date is required',
            'date.date' => 'Booking date must be a date',
            'slot.date' => 'Booking slot is required',
            'slot.string' => 'Booking slot must be a string',
        ];
    }

    /**
     * Return friendly error messages
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return mixed
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors()->all(), 422));
    }
}
