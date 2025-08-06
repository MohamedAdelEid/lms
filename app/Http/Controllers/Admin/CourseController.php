<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditCourseRequest;
use App\Http\Requests\StoreCourseRequest;
use App\Models\Admin\Admin;
use App\Models\Dashboard\Category;
use App\Models\Dashboard\Course;
use App\Models\Dashboard\Instructor;
use App\Traits\UploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    use UploadImage;

    public function show()
    {
        $adminData = Admin::find(Auth::guard('admin')->id());
        return view('admin.view.viewCourses', compact('adminData'));
    }

    public function viewEditCourse($id)
    {
        $adminData = Admin::find(Auth::guard('admin')->id());
        $instructors = Instructor::all();
        $categories = Category::all();
        $currentCourseData = Course::find($id);
        
        if (!$currentCourseData) {
            return redirect()->route('viewCourses')->with('error', 'Course not found');
        }
        
        return view('admin.editPages.editCourse',
            compact('currentCourseData', 'adminData', 'instructors', 'categories'));
    }

    public function editCourse(Request $request, $id)
    {
        // Custom validation rules
        $rules = [
            'course_title' => 'required|string|max:255',
            'course_description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'instructor_id' => 'required|exists:instructors,id',
            'status' => 'required|in:active,upcoming,deactivated,completed',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];

        $messages = [
            'course_title.required' => 'Course title is required',
            'course_title.max' => 'Course title must not exceed 255 characters',
            'course_description.required' => 'Course description is required',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be a valid number',
            'price.min' => 'Price must be at least 0',
            'category_id.required' => 'Category is required',
            'category_id.exists' => 'Selected category is invalid',
            'instructor_id.required' => 'Instructor is required',
            'instructor_id.exists' => 'Selected instructor is invalid',
            'status.required' => 'Status is required',
            'status.in' => 'Invalid status selected',
            'cover_image.image' => 'Cover image must be an image file',
            'cover_image.mimes' => 'Cover image must be jpeg, png, jpg, or gif',
            'cover_image.max' => 'Cover image must not exceed 2MB'
        ];

        $validatedData = $request->validate($rules, $messages);

        $currentCourse = Course::find($id);
        
        if (!$currentCourse) {
            return redirect()->route('viewCourses')->with('error', 'Course not found');
        }

        // Check what fields have changed
        $changes = [];
        $changeMessages = [];

        if ($currentCourse->course_title != $validatedData['course_title']) {
            $changes['course_title'] = $validatedData['course_title'];
            $changeMessages[] = 'Course Title';
        }

        if ($currentCourse->course_description != $validatedData['course_description']) {
            $changes['course_description'] = $validatedData['course_description'];
            $changeMessages[] = 'Course Description';
        }

        if ($currentCourse->price != $validatedData['price']) {
            $changes['price'] = $validatedData['price'];
            $changeMessages[] = 'Price';
        }

        if ($currentCourse->category_id != $validatedData['category_id']) {
            $changes['category_id'] = $validatedData['category_id'];
            $changeMessages[] = 'Category';
        }

        if ($currentCourse->instructor_id != $validatedData['instructor_id']) {
            $changes['instructor_id'] = $validatedData['instructor_id'];
            $changeMessages[] = 'Instructor';
        }

        if ($currentCourse->status != $validatedData['status']) {
            $changes['status'] = $validatedData['status'];
            $changeMessages[] = 'Status';
        }

        // Handle image upload
        $imageUpdated = false;
        if ($request->hasFile('cover_image')) {
            try {
                // Delete old image if it exists and is not the default
                if ($currentCourse->cover_image && $currentCourse->cover_image !== 'default.jpg') {
                    $oldImagePath = public_path('images/CoursesCoverImages/' . $currentCourse->cover_image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // Upload new image
                $coverImageName = $this->UploadImage($request, 'cover_image', 'CoursesCoverImages');
                $changes['cover_image'] = $coverImageName;
                $changeMessages[] = 'Cover Image';
                $imageUpdated = true;
            } catch (\Exception $e) {
                return redirect()->route('admin.editCourse', $currentCourse->id)
                    ->with('error', 'Failed to upload image: ' . $e->getMessage());
            }
        }

        // If no changes were made
        if (empty($changes)) {
            return redirect()->route('admin.editCourse', $currentCourse->id)
                ->with('error', 'No changes were made');
        }

        // Update the course
        try {
            $currentCourse->update($changes);

            // Create success message
            $successMessage = 'Successfully updated: ' . implode(', ', $changeMessages);

            return redirect()->route('admin.editCourse', $currentCourse->id)
                ->with('success', $successMessage);

        } catch (\Exception $e) {
            return redirect()->route('admin.editCourse', $currentCourse->id)
                ->with('error', 'Failed to update course: ' . $e->getMessage());
        }
    }

    public function addCourse()
    {
        $adminData = Admin::find(Auth::guard('admin')->id());
        $instructors = Instructor::all();
        $categories = Category::all();
        return view('admin.add.addCourse', compact('categories', 'instructors', 'adminData'));
    }

    public function storeCourse(StoreCourseRequest $storeCourseRequest)
    {
        try {
            $authId = Auth::guard('admin')->id();
            $coverImageName = $this->UploadImage($storeCourseRequest, 'cover_image', 'CoursesCoverImages');

            Course::create([
                'course_title' => $storeCourseRequest->course_title,
                'course_description' => $storeCourseRequest->course_description,
                'status' => $storeCourseRequest->status,
                'cover_image' => $coverImageName,
                'price' => $storeCourseRequest->price,
                'admin_id' => $authId,
                'category_id' => $storeCourseRequest->category_id,
                'instructor_id' => $storeCourseRequest->instructor_id,
            ]);

            return redirect()->route('admin.addCourse')->with('success', 'Course Created Successfully');

        } catch (\Exception $e) {
            return redirect()->route('admin.addCourse')->with('error', 'Failed to create course: ' . $e->getMessage());
        }
    }
}
