<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditInstructorRequest;
use App\Http\Requests\StoreInstructorRequest;
use App\Models\Admin\Admin;
use App\Models\Dashboard\Instructor;
use App\Traits\UploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructorController extends Controller
{
    use UploadImage;
    public function show()
    {
        $adminData = Admin::find(Auth::guard('admin')->id());
        return view('admin.view.viewInstructors',compact('adminData'));

    }
    public function viewEditInstructor($id){
        $adminData = Admin::find(Auth::guard('admin')->id());
        $currentInstructorData = Instructor::find($id);
        return view('admin.editPages.editInstructor',compact('currentInstructorData','adminData'));
    }

    public function editInstructor(EditInstructorRequest $instructorRequest , $id){
        $currentInstructor = Instructor::find($id);
        $changes = [
            'first_name' => $instructorRequest->first_name,
            'last_name' => $instructorRequest->last_name,
            'email' => $instructorRequest->email,
            'phone_number' => $instructorRequest->phone_number,
            'qualifications' => $instructorRequest->qualifications,
        ];

        $changedFields = array_filter($changes, function ($value, $key) use ($currentInstructor) {
            return $currentInstructor->{$key} != $value;
        }, ARRAY_FILTER_USE_BOTH);

        if (empty($changedFields)) {
            return redirect()->route('admin.editCourse', $currentInstructor->id)->with('info', 'No Changes');
        }

        $successMessages = [];

        foreach ($changedFields as $field => $value) {
            switch ($field) {
                case 'first_name':
                    $successMessages[] = 'First Name Updated Successfully';
                    break;
                case 'last_name':
                    $successMessages[] = 'Last Name Updated Successfully';
                    break;
                case 'email':
                    $successMessages[] = 'Email Address Updated Successfully';
                    break;
                case 'phone_number':
                    $successMessages[] = 'Phone Number Updated Successfully';
                    break;
                case 'qualifications':
                    $successMessages[] = 'Qualification Updated Successfully';
                    break;
            }
        }
        // First Name Cases
        if (isset($changedFields['first_name']) && isset($changedFields['last_name'])) {
            $successMessages[] = 'First Name And Last Name Updated Successfully';
        }if (isset($changedFields['first_name']) && isset($changedFields['email'])) {
            $successMessages[] = 'First Name And Email Address Updated Successfully';
        }if (isset($changedFields['first_name']) && isset($changedFields['phone_number'])) {
            $successMessages[] = 'First Name And Phone Number Updated Successfully';
        }if (isset($changedFields['first_name']) && isset($changedFields['qualifications'])) {
            $successMessages[] = 'First Name And Qualification Updated Successfully';
        }
        // Last Name Cases
        if (isset($changedFields['last_name']) && isset($changedFields['email'])) {
            $successMessages[] = 'Last Name And Email Address Updated Successfully';
        }if (isset($changedFields['last_name']) && isset($changedFields['phone_number'])) {
            $successMessages[] = 'Last Name And Phone Number Updated Successfully';
        }if (isset($changedFields['last_name']) && isset($changedFields['qualifications'])) {
            $successMessages[] = 'Last Name And Qualification Updated Successfully';
        }

        //email Cases
        if (isset($changedFields['email']) && isset($changedFields['phone_number'])) {
            $successMessages[] = 'Email Address And Phone Number Updated Successfully';
        }if (isset($changedFields['email']) && isset($changedFields['qualifications'])) {
            $successMessages[] = 'Email Address And Qualification Updated Successfully';
        }
        // Phone Cases
        if (isset($changedFields['phone_number']) && isset($changedFields['qualifications'])) {
            $successMessages[] = 'Phone Number And Qualification Updated Successfully';
        }
        $currentInstructor->update($changedFields);

        $successMessage = '';
        if (count($changedFields) === count($changes)) {
            $successMessages = ['All Instructor Data Updated Successfully'];
        }
        // Check if there are multiple messages
        if (count($successMessages) > 1) {
            $combinedMessages = array_filter($successMessages, function ($message) {
                return strpos($message, ' And ') !== false;
            });

            if (!empty($combinedMessages)) {
                $successMessage = reset($combinedMessages) . ', ';
            }
        } else {
            $successMessage = reset($successMessages) . ', ';
        }

        // If no combined messages, use the regular approach
        if ($successMessage === '') {
            foreach ($successMessages as $message) {
                $successMessage .= $message . ', ';
            }
        }
        $successMessage = rtrim($successMessage);
        return redirect()->route('admin.editInstructor', $currentInstructor->id)->with('success', $successMessage);
    }
    public function addInstructor(){
        $adminData = Admin::find(Auth::guard('admin')->id());
        return view('admin.add.addInstructor',compact('adminData'));
    }
    public function storeInstructor(StoreInstructorRequest $storeInstructorRequest){
        $adminId = Auth::guard('admin')->id();
        $imageName = $this->uploadImage($storeInstructorRequest, 'profile_picture', 'instructors');
        Instructor::create([
            'first_name'=>$storeInstructorRequest->first_name,
            'last_name'=>$storeInstructorRequest->last_name,
            'email'=>$storeInstructorRequest->email,
            'password'=>$storeInstructorRequest->password,
            'phone_number'=>$storeInstructorRequest->phone_number,
            'profile_picture'=>$imageName,
            'qualifications'=>$storeInstructorRequest->qualifications,
            'admin_id'=>$adminId,
        ]);
        return redirect()->route('admin.addInstructor')->with('success','Instructor Created Successfully');
    }
}
