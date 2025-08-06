<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstructorRequest extends FormRequest
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
            'first_name'=>'required|string|max:50|regex:/^[\pL\s\-]+$/u',
            'last_name'=>'required|string|max:50|regex:/^[\pL\s\-]+$/u',
            'email'=>'required|email|unique:instructors,email|max:255',
            'password'=>'required|string|min:8',
            'phone_number' => 'required|numeric|regex:/^01[0-2]\d{8}$/|unique:instructors,phone_number',
            'profile_picture' => 'nullable|file|image|mimes:jpg,png,jpeg|max:5120',
            'qualifications' => 'required|string',
        ];
    }
    public  function messages()
    {
        return [
            'first_name.required'=>'Title Is Required ',
            'first_name.string'=> 'Please Enter Text',
            'first_name.max'=> 'Please Enter Shortest Text',
            'first_name.regex'=> 'Please Enter Text Only',
            'last_name.required'=>'Description Is Required ',
            'last_name.string'=> 'Please Enter Text',
            'last_name.max'=> 'Please Enter Shortest Text',
            'last_name.regex'=> 'Please Enter Text Only',
            'email.required' => 'Please Enter An email Address.',
            'email.email' => 'Please Enter a Valid email Address.',
            'email.unique' => 'This email Address is Already Exists.',
            'password.required' => 'Please Enter a Password.',
            'password.string' =>'Please Enter Valid Password',
            'password.min' => 'Password must be at least : 8 characters.',
            'profile_picture.image' => 'Profile picture must be an image.',
            'profile_picture.mimes' => 'Profile Picture Must Be a Valid Image Format (jpeg, png, jpg, gif).',
            'profile_picture.max' => 'Profile Picture Size Must Be Less than :5MB.',
            'qualifications.required' => 'Please Enter Qualifications.',
            'phone_number.required' => 'Please Enter a Phone Number.',
            'phone_number.regex' => 'Please Enter a Valid Number.',
            'phone_number.unique' => 'This Phone Number Already Exists.',
        ];
    }
}
