<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSectionRequest extends FormRequest
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
            'section_name'=>'required|string|max:255',
            'number_of_lectures'=>'required|numeric|min:0',
            'course_id'=>'required|exists:courses,id',
        ];
    }
    public  function messages()
    {
        return [
            'section_name.required'=>'Name Is Required ',
            'section_name.string'=> 'Please Enter Text',
            'section_name.max'=> 'Please Enter Shortest Text',
            'number_of_lectures.required'=>'Please Enter  Number Of Lectures',
            'number_of_lectures.numeric'=>'Must Be Numeric Value',
            'number_of_lectures.min'=>'Must be at Least 0 ',
            'course_id.required'=>'Please Enter Course',
            'course_id.exists'=>'Invalid Course',
        ];
    }
}
