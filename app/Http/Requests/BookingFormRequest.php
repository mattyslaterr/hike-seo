<?php

namespace App\Http\Requests;

use App\Rules\HasBooking;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\Validator;

class BookingFormRequest extends FormRequest
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
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'phone_number' => ['required'],
            'make' => ['required', 'string'],
            'model' => ['required', 'string'],
            'date' => ['required', 'date'],
            'slot' => ['required', new HasBooking($this->input('date'))],
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First name is required',
            'first_name.string' => 'First name must be a string',
            'last_name.required' => 'Last name is required',
            'last_name.string' => 'Last name must be a string',
            'email.required' => 'Email address is required',
            'email.email' => 'Email address is invalid',
            'phone_number.required' => 'Phone number is required',
            'phone_number.number' => 'Phone number must be a number',
            'make.required' => 'Make is required',
            'make.string' => 'Make must be a string',
            'model.required' => 'Model is required',
            'model.string' => 'Model must be a string',
            'date.required' => 'Booking date is required',
            'date.string' => 'Booking date must be a date',
            'slot.required' => 'Booking slot is required',
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
