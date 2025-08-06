<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditCourseRequest extends FormRequest
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
            'course_title'=>'required|string|max:255',
            'course_description'=>'required|string|max:255',
            'status'=>'required|in:active,upcoming,deactivated,completed',
            'price'=>'required|numeric|min:0',
            'category_id'=>'required|exists:categories,id',
            'instructor_id'=>'required|exists:instructors,id',
        ];
    }
    public  function messages()
    {
        return [
            'course_title.required'=>'Title Is Required ',
            'course_title.string'=> 'Please Enter Text',
            'course_title.max'=> 'Please Enter Shortest Text',
            'course_description.required'=>'Description Is Required ',
            'course_description.string'=> 'Please Enter Text',
            'course_description.max'=> 'Please Enter Shortest Text',
            'status.required'=>'Please Select Course Status',
            'status.in'=>'Invalid Status',
            'price.required'=>'Please Enter Price',
            'price.numeric'=>'The Price Must Be Numeric Value',
            'price.min'=>'The Price Must be at Least 0 ',
            'category_id.required'=>'Please Enter Category',
            'category_id.exists'=>'Invalid Category',
            'instructor_id.required'=>'Please Enter Instructor',
            'instructor_id.exists'=>'Invalid Instructor',
        ];
    }
}
