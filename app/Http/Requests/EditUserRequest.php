<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
            'name' => 'required|string|max:50|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|email|unique:users,email,' . $this->route('id') . '|max:255',
            'phone_number' => 'required|numeric|regex:/^01[0-2]\d{8}$/|unique:users,phone_number,' . $this->route('id'),
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'name.string' => 'Please enter text for the name.',
            'name.max' => 'Please enter a name with a maximum of 50 characters.',
            'name.regex' => 'Please enter only text for the name.',
            'email.required' => 'Please enter an email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already taken.',
            'phone_number.required' => 'Please enter a phone number.',
            'phone_number.regex' => 'Please enter a valid Egyptian phone number.',
            'phone_number.unique' => 'This phone number is already taken.',
        ];
    }
}
