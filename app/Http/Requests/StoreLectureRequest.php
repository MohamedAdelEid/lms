<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLectureRequest extends FormRequest
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
            'lecture_name' => 'required|string|max:255',
            'lecture_description' => 'required|string|max:255',
            'video_path' => 'required|mimes:mp4,mov,ogg|max:512000',
            'section_id' => 'required|exists:sections,id',
            'course_id' => 'required|exists:courses,id',
            'cover_image' => 'required|file|image|mimes:jpg,png,jpeg|max:5120',
        ];
    }
    public function messages()
    {
        return [
            'lecture_name.required'=>'Lecture Name Is Required ',
            'lecture_name.string'=> 'Please Enter Text',
            'lecture_name.max'=> 'Please Enter Shortest Text',
            'lecture_description.required'=>'Description Is Required ',
            'lecture_description.string'=> 'Please Enter Text',
            'lecture_description.max'=> 'Please Enter Shortest Text',
            'video_path.required'=>'Video Is Required',
            'video_path.mimes'=>'Please Insert Valid Video Format (mp4, mov, ogg)',
            'video_path.max'=>'Video Size Must Be Less than :500MB.',
            'section_id.required'=>'Please Choose Section',
            'section_id.exists'=>'Invalid Section',
            'course_id.required'=>'Please Choose Course',
            'course_id.exists'=>'Invalid Course',
            'cover_image.required'=>'Cover Picture Is Required ',
            'cover_image.image' => 'Cover Image must be an image.',
            'cover_image.mimes' => 'Cover Image Must Be a Valid Image Format (jpeg, png, jpg, gif).',
            'cover_image.max' => 'Cover Image Size Must Be Less than :5MB.',
        ];
    }
}
