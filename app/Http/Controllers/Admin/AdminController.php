<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\Dashboard\Category;
use App\Models\Dashboard\Course;
use App\Models\Dashboard\Instructor;
use App\Models\Dashboard\Lecture;
use App\Models\Dashboard\Section;
use App\Models\User\User;
use App\Traits\UploadImage;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
use UploadImage;
    public function myProfile(){
        $adminData = Admin::find(Auth::guard('admin')->id());
        return view('admin.myProfile',compact('adminData'));
    }
 public function updateOrDeleteProfilePicture(Request $request){
      if($request->has('delete')){
          $this->deleteProfilePicture();
          return redirect()->route('admin.myProfile')->with('Profile-success', 'Profile Picture Deleted Successfully');

      }else{
          $this->updateProfilePicture($request);
          return redirect()->route('admin.myProfile')->with('Profile-success', 'Profile Picture  Updated Successfully');
      }
 }
    public function updateProfilePicture(Request $request){
        $request->validate([
            'profile_picture' => 'file|image|mimes:jpg,png,jpeg|max:5120'
        ]);
        $admin = Auth::guard('admin')->user();
        $imageName = $this->UploadImage($request,'profile_picture','admins');
        $admin->update([
            'profile_picture'=> $imageName
        ]);
        $admin->save();

    }
    public function deleteProfilePicture(){
        $admin = Auth::guard('admin')->user();
        $imageFolder = 'admins';

        // Get the current profile picture name from the database
        $currentProfilePicture = $admin->profile_picture;

        // Delete the profile picture file from storage
        $filePath = 'images/' . $imageFolder . '/' . $currentProfilePicture;
        if ($currentProfilePicture && File::exists(public_path($filePath))) {
            unlink(public_path($filePath));
        }

        // Update the profile picture field in the database
        $admin->profile_picture = 'default.jpg';
        $admin->save();
    }

    public function changePersonalDetails(Request $request){
        $rules = [
            'first_name' => 'required|string|max:50|regex:/^[\pL\s\-]+$/u',
            'last_name' => 'required|string|max:50|regex:/^[\pL\s\-]+$/u',
            'phone_number' => 'numeric|regex:/^01[0-2]\d{8}$/',
        ];

        $messages = [
            'first_name.required' => 'Please Enter First Name',
            'first_name.max' => 'Please Enter Shortest Name',
            'first_name.regex' => 'Please Enter Text only',
            'last_name.required' => 'Please Enter Last Name',
            'last_name.max' => 'Please Enter Shortest Name',
            'last_name.regex' => 'Please Enter Text only',
            'phone_number.regex' => 'Please Enter a Valid Number.',
        ];

        // Only add the unique rule if the phone number is changed
        if ($request->phone_number != Auth::guard('admin')->user()->phone_number) {
            $rules['phone_number'] .= '|unique:admins,phone_number';
            $messages['phone_number.unique'] = 'This Phone Number Already Exists.';
        }

        $request->validate($rules, $messages);
        // find admin Data
        $admin = Admin::find(Auth::guard('admin')->id());
        // Update Only Phone Number
        if ($request->phone_number != $admin->phone_number) {
            // Update only phone number
            $admin->update([
                'phone_number' => $request->phone_number,
            ]);
            return redirect()->back()->with('success', 'Phone Number Updated Successfully');
        } elseif ($request->first_name != $admin->first_name || $request->last_name != $admin->last_name) {
            // Update only name fields
            $admin->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
            ]);
            return redirect()->back()->with('success', 'Name Updated Successfully');
        } elseif ($request->first_name != $admin->first_name ||
            $request->last_name != $admin->last_name ||
            $request->phone_number != $admin->phone_number) {
            // Update all fields
            $admin->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
            ]);
            return redirect()->back()->with('success', 'Personal Details Updated Successfully');
        } else {
            // No fields were changed
            return redirect()->back()->with('info', 'No changes made');
        }
    }
    public function changePassword(Request $request){
        $request->validate([
            'old_password'=>'required',
            'new_password'=>'required|min:8',
            'confirm_password'=>'required|min:8|same:new_password',
        ]);
        $admin = Admin::find(Auth::guard('admin')->id());
        if(!Hash::check($request->old_password,$admin->password)){
            return redirect()->back()->with('error','Incorrect old password');
        }
        $admin->update([
            'password'=>Hash::make($request->new_password),
        ]);
        return redirect()->back()->with('success', 'Password Changed Successfully');

    }
    public function login_form()
    {
        return view('Admin.loginAdmin');
    }
    public function login_functionality(Request $request){


        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:8',
        ],
            [
                'email.required' => 'The email field is required.',
                'email.email' => 'Please enter a valid email address.',
                'password.required' => 'The password field is required.',
                'password.min' => 'The password must be at least :min characters long.',
            ]
        );

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('admin.dashboard');
        }else{
            Session::flash('error-message','Invalid Email or Password');
            return back();
        }
    }
    public function fetchSections(Request $request)
    {
        $courseId = $request->input('course_id');

        // Fetch sections associated with the selected course
        $course = Course::find($courseId);
        $sections = $course ? $course->sections()->pluck('section_name', 'id') : [];

        // Return sections data as JSON response
        return response()->json($sections);
    }
    public function dashboard()
    {
        $allCategories = Category::all();
        $lastFiveCategories = Category::orderBy('created_at', 'desc')->take(5)->get();
        $allCourses = Course::all();
        $lastFiveCourses = Course::orderBy('created_at', 'desc')->take(5)->get();
        $allSections = Section::all();
        $lastFiveSections = Section::orderBy('created_at', 'desc')->take(5)->get();
        $allLectures = Lecture::all();
        $lastFiveLectures = Lecture::orderby('created_at','desc')->take(5)->get();
        $allUsers = User::all();
        $lastFiveUsers = User::orderBy('created_at', 'desc')->take(5)->get();
        $allInstructors = Instructor::all();
        $lastFiveInstructors = Instructor::orderBy('created_at', 'desc')->take(5)->get();
        $adminData = Admin::find(Auth::guard('admin')->id());
        $numberOfCategories = Category::all()->count();
        $numberOfCourses = Course::all()->count();
        $numberOfInstructors = Instructor::all()->count();
        $numberOfUsers = User::all()->count();
        return view('admin.dashboard',
            compact('allCategories','lastFiveCategories',
            'allCourses','lastFiveCourses','lastFiveSections','allSections','lastFiveUsers',
               'numberOfCategories','adminData','allLectures','lastFiveLectures',
                'allUsers','allInstructors','lastFiveInstructors',
                 'numberOfCourses','numberOfInstructors','numberOfUsers'));
    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->forget('guard.admin');
        return redirect()->route('login.form');
    }









}
