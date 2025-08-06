<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\Admin\Admin;
use App\Models\Dashboard\Category;
use App\Models\Dashboard\Course;
use App\Models\Dashboard\Discussions;
use App\Models\Dashboard\Lecture;
use App\Models\Dashboard\Section;
use App\Models\Dashboard\Video;
use App\Models\User\User;
use App\Models\UserCourse;
use App\Models\UserCourseSection;
use App\Traits\UploadImage;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use mysql_xdevapi\Exception;

class UserController extends Controller
{
    use UploadImage;
    public function show()
    {
        $adminData = Admin::find(Auth::guard('admin')->id());
        return view('admin.view.viewUsers',compact('adminData'));
    }
    public function viewEditUser($id){
        $adminData = Admin::find(Auth::guard('admin')->id());
        $currentUserData = User::find($id);
        return view('admin.editPages.editUser',compact('currentUserData','adminData'));
    }
    public function editUser(EditUserRequest $editUserRequest , $id)
    {
        $currentUser = User::find($id);

        if (!$currentUser) {
            return redirect()->route('admin.editUser',$currentUser->id)->with('error', 'User not found');
        }
        $userNameChanged = $currentUser->name != $editUserRequest->name;
        $PhoneChanged = $currentUser->phone_number != $editUserRequest->phone_number;
        $emailChanged = $currentUser->email != $editUserRequest->email;


        if ($userNameChanged && !$PhoneChanged && !$emailChanged) {
            $currentUser->update([
                'name' => $editUserRequest->section_name
            ]);
            return redirect()->route('admin.editUser', $currentUser->id)->with('success', 'Name Updated Successfully');
        }

        if (!$userNameChanged && $PhoneChanged && !$emailChanged) {
            $currentUser->update([
                'phone_number' => $editUserRequest->number_of_lectures
            ]);
            return redirect()->route('admin.editUser', $currentUser->id)->with('success', 'Phone Number Updated Successfully');
        }

        if (!$userNameChanged && !$PhoneChanged && $emailChanged) {
            $currentUser->update([
                'email' => $editUserRequest->email
            ]);
            return redirect()->route('admin.editUser', $currentUser->id)->with('success', 'Email Address Updated Successfully');
        }
        if (!$userNameChanged && $PhoneChanged && $emailChanged) {
            $currentUser->update([
                'email' => $editUserRequest->email,
                'phone_number' => $editUserRequest->phone_number
            ]);
            return redirect()->route('admin.editUser', $currentUser->id)->with('success', 'Email Address And Phone Number Updated Successfully');
        }
        if ($userNameChanged && $PhoneChanged && !$emailChanged) {
            $currentUser->update([
                'name' => $editUserRequest->name,
                'phone_number' => $editUserRequest->phone_number
            ]);
            return redirect()->route('admin.editUser', $currentUser->id)->with('success', 'Name And Phone Number Updated Successfully');
        }
        if ($userNameChanged && !$PhoneChanged && $emailChanged) {
            $currentUser->update([
                'name' => $editUserRequest->name,
                'email' => $editUserRequest->email
            ]);
            return redirect()->route('admin.editUser', $currentUser->id)->with('success', 'Name And Email Address Updated Successfully');
        }

        if ($userNameChanged && $PhoneChanged && $emailChanged) {
            $currentUser->update([
                'name' => $editUserRequest->name,
                'phone_number' => $editUserRequest->phone_number,
                'email' => $editUserRequest->email
            ]);
            return redirect()->route('admin.editUser', $currentUser->id)->with('success', 'All User Data Updated');
        }
    }

    public function addUser(){
        $adminData = Admin::find(Auth::guard('admin')->id());
        return view('admin.add.addUser',compact('adminData'));
    }
    public function storeUser(StoreUserRequest $storeUserRequest){
        $adminId = Auth::guard('admin')->id();
        $hashedPassword = bcrypt($storeUserRequest->password);
        $imageName = $this->UploadImage($storeUserRequest,'profile_picture','users');
        User::create([
            'name'=>$storeUserRequest->name,
            'email'=>$storeUserRequest->email,
            'password'=>$hashedPassword,
            'profile_picture'=>$imageName,
            'phone_number'=>$storeUserRequest->phone_number,
            'admin_id'=>$adminId
        ]);
        return redirect()->route('admin.addUser')->with('success','User Created Successfully');

    }
    public function addCourseToUser(){
        $adminData = Admin::find(Auth::guard('admin')->id());
        $courses = Course::all();
        return view('admin.add.addCourseToUser',compact('adminData','courses'));
    }
    public function storeCourseToUser(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'email' => 'required|email|exists:users',
                'course_id' => 'required|exists:courses,id',
                'sections' => 'required|array',
                'sections.*' => 'exists:sections,id',
            ], [
                'email.required' => 'The email field is required.',
                'email.email' => 'The email must be a valid email address.',
                'email.exists' => 'Student Not Found.',

                'course_id.required' => 'The course field is required.',
                'course_id.exists' => 'The Selected Course Is Invalid.',

                'sections.required' => 'At least one section must be selected.',
                'sections.array' => 'The sections must be an array.',
                'sections.*.exists' => 'One or more selected sections are invalid.',
            ]);

            $user = User::where('email', $validatedData['email'])->first();

            if ($user) {
                foreach ($validatedData['sections'] as $sectionId) {
                    $user->courses()->attach($validatedData['course_id'], ['section_id' => $sectionId]);
                }
                UserCourse::create([
                    'user_id'=>$user->id,
                    'course_id'=>$validatedData['course_id'] ,
                ]);
                return redirect()->route('admin.addCourseToUser')->with('success', 'Course assigned successfully');
            } else {
                return redirect()->route('admin.addCourseToUser')->with('error', 'No Student Found');
            }
        }catch (QueryException $e){
            if ($e->errorInfo[1] == 1062) {
                return redirect()->route('admin.addCourseToUser')->with('error', 'Course already assigned to the student.');
            } else {
                // Handle other database-related exceptions if needed
                return redirect()->route('admin.addCourseToUser')->with('error', 'An error occurred. Please try again later.');
            }
        }

    }

    public function editUserInformation(){
        $user = Auth::user();
        return view('user.editPersonalInformation',compact('user'));
    }
    public function index()
    {
        $user = Auth::user();
        $numberOfLikes = Discussions::where('user_id','=',Auth::user()->id)
            ->where('likes','=','1')
            ->count();
        $numberOfComments = Discussions::where('user_id','=',Auth::user()->id)->count();
        $coursesOfLoggedUser = UserCourse::where('user_id','=',Auth::user()->id)->get()->take(6);
        return view('user.home',compact(
            'user',
            'numberOfLikes',
            'numberOfComments',
            'coursesOfLoggedUser'
        ));
    }
    public function viewCourses(){
        $categories = Category::all();
        $courses = Course::orderBy('created_at', 'desc')->take(10)->get();
        $coursesOfLoggedUser = UserCourse::where('user_id','=',Auth::user()->id)->get();
        $user = Auth::user();
        return view('user.courses', compact('user', 'courses', 'categories','coursesOfLoggedUser'));
    }
    public function viewPlaylist($courseId){
        $user = Auth::user();
        $sectionsByCourseIdAndLoggedUser = UserCourseSection::where('course_id','=',$courseId)
                                                            ->where('user_id',$user->id)
                                                            ->get();

        $course = Course::findOrFail($courseId);
        $course->load('sections.lectures.videos');
        return view('user.playlist',compact('user', 'course','sectionsByCourseIdAndLoggedUser'));
    }
    public function watchVideo($lectureId){
        $lecture = Lecture::with('section.course.instructor')->findOrFail($lectureId);
        $video = Video::where('lecture_id', '=', $lectureId)->first(); // Retrieve the video associated with the lecture
        $numberOfLikes = Discussions::where('lecture_id', '=', $lectureId)
            ->where('likes', '=', '1')
            ->count();
        $numberOfComments = Discussions::where('lecture_id', '=', $lectureId)
            ->where('message', '!=', 'NULL')
            ->count();
        $instructorName = $lecture->section->course->instructor->first_name . ' ' . $lecture->section->course->instructor->last_name;
        $instructorImage = $lecture->section->course->instructor->profile_picture;
        $instructorQualification = $lecture->section->course->instructor->qualifications;
        $discussionsByLectureId = Discussions::with('user')
            ->where('lecture_id', '=', $lectureId)
            ->get()
            ->map(function($discussion) {
                // Format the date to Y-m-d format
                $discussion->message_date = Carbon::parse($discussion->message_date)->format('Y-m-d');
                return $discussion;
            });
        $user = Auth::user();

        // Check if the logged-in user has an existing comment
        $existingComment = Discussions::where('lecture_id', $lectureId)
            ->where('user_id', $user->id)
            ->first();

        return view('user.watch-video', compact(
            'numberOfComments',
            'user',
            'lecture',
            'instructorName',
            'discussionsByLectureId',
            'numberOfLikes',
            'instructorImage',
            'instructorQualification',
            'video',
            'existingComment' // Pass the $existingComment variable to the view
        ));
    }

    public function likeVideo(Request $request)
    {
        if ($request->ajax()) {
            $lectureId = $request->lecture_id;
            $userId = Auth::user()->id;

            // Fetch the discussion entry for the given lecture ID and user ID
            $discussion = Discussions::where('lecture_id', $lectureId)
                ->where('user_id', $userId)
                ->first();

            if (!$discussion) {
                // If no discussion entry exists, create a new one with like value 1
                $discussion = Discussions::create([
                    'user_id' => $userId,
                    'lecture_id' => $lectureId,
                    'likes' => '1' // Use string value for enum column
                ]);
            } else {
                // Toggle like status
                $discussion->likes = ($discussion->likes == '0') ? '1' : '0';
                $discussion->save();
            }

            // Update likes count
            $likesCount = Discussions::where('lecture_id', $lectureId)
                ->where('likes', '1')
                ->count();

            return response()->json([
                'success' => true,
                'likesCount' => $likesCount,
                'likeStatus' => $discussion->likes
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid AJAX request']);
    }

    public function edit($id, Request $request)
    {
        $discussion = Discussions::findOrFail($id);

        // Update the message field
        $discussion->message = $request->input('message');
        $discussion->save();

        return response()->json(['success' => true, 'message' => 'Discussion message updated successfully']);
    }

    public function delete($id)
    {
        $discussion = Discussions::findOrFail($id);

        // Convert message field to null
        $discussion->message = null;
        $discussion->save();

        return response()->json(['success' => true, 'message' => 'Discussion message cleared successfully']);
    }

    public function addComment(Request $request, $lectureId){
        $request->validate([
            'comment_box' => 'required|max:255',
        ], [
            'comment_box.required' => 'Comment Body Is Required',
            'comment_box.max' => 'The comment box may not be greater than :255 characters.',
        ]);

        $existingComment = Discussions::with('user')
            ->where('lecture_id', $lectureId)
            ->where('user_id', Auth::user()->id)
            ->first();

        if ($existingComment) {
            // If the user has already made a comment, update the existing comment
            $existingComment->update([
                'message' => $request->comment_box,
                'message_date' => now(),
            ]);
        } else {
            // If the user hasn't made a comment yet, create a new one
            $discussion = Discussions::create([
                'message' => $request->comment_box,
                'lecture_id' => $lectureId,
                'user_id' => Auth::user()->id,
                'message_date' => now(),
            ]);
        }

        $numberOfComments = Discussions::where('lecture_id', $lectureId)->count();
        return response()->json([
            'success' => true,
            'message' => 'Comment added successfully',
            'discussion' => $discussion ?? $existingComment,
            'numberOfComments' => $numberOfComments,
        ]);
    }
    public function myProfile(){
        $user = Auth::user();
        return view('user.myProfile',compact('user'));
    }
    public function handleImage(Request $request){
        $action = $request->input('action');
        if($action == 'delete'){
            $user = Auth::user();
            $imageFolder = 'users';

            // Get the current profile picture name from the database
            $currentProfilePicture = $user->profile_picture;

            // Delete the profile picture file from storage
            $filePath = 'images/' . $imageFolder . '/' . $currentProfilePicture;
            if ($currentProfilePicture && File::exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }

            // Update the profile picture field in the database
            $user->profile_picture = 'default.jpg';
            $user->save();
            return redirect()->back()->with('Profile-success', 'Image Deleted successfully.');

        }
        elseif ($action == 'update') {
            $request->validate([
                'profile_picture' => 'file|image|mimes:jpg,png,jpeg|max:5120'
            ]);
            $user = Auth::user();
            $imageName = $this->UploadImage($request, 'profile_picture', 'users');
            $user->update([
                'profile_picture'=> $imageName
            ]);
            $user->save();
            return redirect()->back()->with('Profile-success', 'Image Updated successfully.');
        }
    }
    public function storeEditUserInformation(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'old_password' => 'nullable|string|min:8',
            'new_password' => 'nullable|string|min:8',
            'confirm_password' => 'nullable|string|min:8|same:new_password',
        ]);

        $user = auth()->user();

        // Check if both name and password are provided
        if ($request->filled(['name', 'old_password', 'new_password'])) {
            // Validate old password
            if (!Hash::check($request->input('old_password'), $user->password)) {
                return redirect()->back()->withErrors(['old_password' => 'The old password is incorrect.']);
            }

            // Update name and password
            $user->update([
                'name' => $request->name,
                'password' => Hash::make($request->new_password)
            ]);

            return redirect()->route('user.editUserInformation')->with('success', 'Personal Information Updated Successfully');
        }

        // Check if only name is provided
        if ($request->filled('name')) {
            $user->update([
                'name' => $request->name
            ]);
            return redirect()->route('user.editUserInformation')->with('success', 'Name Updated Successfully');
        }

        // Check if only password is provided
        if ($request->filled('old_password') && $request->filled('new_password')) {
            if (Hash::check($request->input('old_password'), $user->password)) {
                $user->update([
                    'password' => Hash::make($request->new_password)
                ]);
                return redirect()->back()->with('success', 'Password Updated Successfully.');
            } else {
                return redirect()->back()->withErrors(['old_password' => 'The old password is incorrect.']);
            }
        }

        return redirect()->route('user.editUserInformation')->with('error', 'No Changes');
    }
    public function viewContactUs(){
        $user = Auth::user();
        return view('user.contactUs',compact('user'));
    }
}
