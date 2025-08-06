<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLectureRequest;
use App\Models\Admin\Admin;
use App\Models\Dashboard\Course;
use App\Models\Dashboard\Lecture;
use App\Models\Dashboard\Section;
use App\Models\Dashboard\Video;
use App\Traits\UploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class LectureController extends Controller
{
    use UploadImage;

    public function show()
    {
        $adminData = Admin::find(Auth::guard('admin')->id());
        return view('admin.view.viewLectures', compact('adminData'));
    }

    public function viewEditLecture($id)
    {
        $adminData = Admin::find(Auth::guard('admin')->id());
        $currentLectureData = Lecture::with('videos')->find($id);
        $sections = $currentLectureData->section->course->sections;
        return view('admin.editPages.editLecture', compact('adminData', 'sections', 'currentLectureData'));
    }

    public function viewLectureVideo($id, $video = null)
    {
        $adminData = Admin::find(Auth::guard('admin')->id());
        $lecture = Lecture::with('videos')->findOrFail($id);
        
        if ($video) {
            $selectedVideo = Video::findOrFail($video);
        } else {
            $selectedVideo = $lecture->videos->first();
        }

        if (!$selectedVideo) {
            abort(404, 'Video not found');
        }

        return view('admin.view.viewLectureVideo', compact('adminData', 'lecture', 'selectedVideo'));
    }

    public function editLecture(Request $request, $id)
    {
        // Validation rules
        $rules = [
            'lecture_name' => 'required|string|max:255',
            'section_id' => 'required|exists:sections,id',
            'descriptionLecture' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_path' => 'nullable|mimes:mp4,avi,mov,wmv|max:102400' // 100MB max
        ];

        // Custom validation messages
        $messages = [
            'descriptionLecture.required' => 'Description Is Required',
            'descriptionLecture.string' => 'Please Enter Text',
            'descriptionLecture.max' => 'Please Enter Shortest Text',
            'section_id.exists' => 'The selected section is invalid.',
            'cover_image.image' => 'Cover image must be an image file.',
            'cover_image.mimes' => 'Cover image must be jpeg, png, jpg, or gif.',
            'cover_image.max' => 'Cover image must not exceed 2MB.',
            'video_path.mimes' => 'Video must be mp4, avi, mov, or wmv format.',
            'video_path.max' => 'Video must not exceed 100MB.'
        ];

        // Validate the request data
        $validatedData = $request->validate($rules, $messages);

        $currentLectureData = Lecture::with('videos')->find($id);

        // Check for changes
        $lectureNameChanged = $currentLectureData->lecture_name != $validatedData['lecture_name'];
        $sectionIdChanged = $currentLectureData->section_id != $validatedData['section_id'];
        $descriptionChanged = $currentLectureData->lecture_description != $validatedData['descriptionLecture'];
        $hasNewCover = $request->hasFile('cover_image');
        $hasNewVideo = $request->hasFile('video_path');

        if (!$lectureNameChanged && !$sectionIdChanged && !$descriptionChanged && !$hasNewCover && !$hasNewVideo) {
            return redirect()->route('admin.editLecture', $currentLectureData->id)->with('error', 'No Changes');
        }

        // Update lecture data
        $updateData = [];
        if ($lectureNameChanged) {
            $updateData['lecture_name'] = $validatedData['lecture_name'];
        }
        if ($sectionIdChanged) {
            $updateData['section_id'] = $validatedData['section_id'];
        }
        if ($descriptionChanged) {
            $updateData['lecture_description'] = $validatedData['descriptionLecture'];
        }

        if (!empty($updateData)) {
            $currentLectureData->update($updateData);
        }

        // Handle cover image update
        if ($hasNewCover && $currentLectureData->videos->isNotEmpty()) {
            $coverImageName = $this->UploadImage($request, 'cover_image', 'VideoCoverImages');
            $currentLectureData->videos->first()->update(['cover_image' => $coverImageName]);
        }

        // Handle video update
        if ($hasNewVideo) {
            $videoFile = $request->file('video_path');
            $section = Section::find($validatedData['section_id']);
            $course = Course::find($section->course_id);
            
            $courseName = $course->course_title;
            $sectionName = $section->section_name;
            $lectureName = $currentLectureData->lecture_name;
            
            $video_name = time() . '-vid.' . $videoFile->getClientOriginalExtension();
            $directory = "{$courseName}/{$sectionName}/{$lectureName}";
            $videoPath = Storage::disk('public/videos')->putFileAs($directory, $videoFile, $video_name);
            
            // Update existing video or create new one
            if ($currentLectureData->videos->isNotEmpty()) {
                $currentLectureData->videos->first()->update([
                    'name' => $video_name,
                    'video_path' => $videoPath
                ]);
            } else {
                Video::create([
                    'name' => $video_name,
                    'video_path' => $videoPath,
                    'lecture_id' => $currentLectureData->id,
                    'cover_image' => $hasNewCover ? $coverImageName : 'default-cover.jpg'
                ]);
            }
        }

        return redirect()->route('admin.editLecture', $currentLectureData->id)->with('success', 'Lecture Updated Successfully');
    }

    public function addLecture()
    {
        $adminData = Admin::find(Auth::guard('admin')->id());
        $courses = Course::all();
        $sections = Section::all();
        return view('admin.add.addLecture', compact('courses', 'sections', 'adminData'));
    }

    public function storeLecture(StoreLectureRequest $storeLectureRequest)
    {
        $adminId = Auth::guard('admin')->id();
        $coverImageName = $this->UploadImage($storeLectureRequest, 'cover_image', 'VideoCoverImages');
        $sectionId = $storeLectureRequest->input('section_id');

        $lecture = Lecture::create([
            'lecture_name' => $storeLectureRequest->lecture_name,
            'lecture_description' => $storeLectureRequest->lecture_description,
            'section_id' => $sectionId,
            'admin_id' => $adminId,
        ]);

        $videoFile = $storeLectureRequest->file('video_path');
        $section = Section::find($sectionId);
        $course = Course::find($section->course_id);
        $courseName = $course->course_title;
        $sectionName = $section->section_name;
        $lectureName = $lecture->lecture_name;

        $video_name = time() . '-vid.' . $videoFile->getClientOriginalExtension();
        $directory = "{$courseName}/{$sectionName}/{$lectureName}";
        $videoPath = Storage::disk('public/videos')->putFileAs($directory, $videoFile, $video_name);

        Video::create([
            'name' => $video_name,
            'video_path' => $videoPath,
            'lecture_id' => $lecture->id,
            'cover_image' => $coverImageName
        ]);

        return redirect()->route('admin.addLecture')->with('success', 'Lecture Created Successfully');
    }
}
