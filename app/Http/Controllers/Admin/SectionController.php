<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSectionRequest;
use App\Models\Admin\Admin;
use App\Models\Dashboard\Course;
use App\Models\Dashboard\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    public function show()
    {
        $adminData = Admin::find(Auth::guard('admin')->id());
        return view('admin.view.viewSections',compact('adminData'));

    }
    public function viewEditSection($id){
        $adminData = Admin::find(Auth::guard('admin')->id());
        $currentSectionData =  Section::find($id);
        $courses = Course::all();
        return view('admin.editPages.editSection',compact('courses','currentSectionData','adminData'));
    }
    public function editSection(StoreSectionRequest $sectionRequest, $id)
    {

        $currentSection = Section::find($id);
        $sectionNameChanged = $currentSection->section_name != $sectionRequest->section_name;
        $numberOfLecturesChanged = $currentSection->number_of_lectures != $sectionRequest->number_of_lectures;
        $courseIdChanged = $currentSection->course_id != $sectionRequest->course_id;

        if ($sectionNameChanged && !$numberOfLecturesChanged && !$courseIdChanged) {
            $currentSection->update([
                'section_name' => $sectionRequest->section_name
            ]);
            return redirect()->route('admin.editSection', $currentSection->id)->with('success', 'Section Name Updated Successfully');
        }

        if (!$sectionNameChanged && $numberOfLecturesChanged && !$courseIdChanged) {
            $currentSection->update([
                'number_of_lectures' => $sectionRequest->number_of_lectures
            ]);
            return redirect()->route('admin.editSection', $currentSection->id)->with('success', 'Number of Lectures Updated Successfully');
        }

        if (!$sectionNameChanged && !$numberOfLecturesChanged && $courseIdChanged) {
            $currentSection->update([
                'course_id' => $sectionRequest->course_id
            ]);
            return redirect()->route('admin.editSection', $currentSection->id)->with('success', 'Course Name Updated Successfully');
        }
        if (!$sectionNameChanged && $numberOfLecturesChanged && $courseIdChanged) {
            $currentSection->update([
                'course_id' => $sectionRequest->course_id,
                'number_of_lectures' => $sectionRequest->number_of_lectures
            ]);
            return redirect()->route('admin.editSection', $currentSection->id)->with('success', 'Course Name And Number Of Lectures Updated Successfully');
        }
        if ($sectionNameChanged && $numberOfLecturesChanged && !$courseIdChanged) {
            $currentSection->update([
                'section_name' => $sectionRequest->section_name,
                'number_of_lectures' => $sectionRequest->number_of_lectures
            ]);
            return redirect()->route('admin.editSection', $currentSection->id)->with('success', 'Section Name And Number Of Lectures Updated Successfully');
        }
        if ($sectionNameChanged && !$numberOfLecturesChanged && $courseIdChanged) {
            $currentSection->update([
                'section_name' => $sectionRequest->section_name,
                'course_id' => $sectionRequest->course_id
            ]);
            return redirect()->route('admin.editSection', $currentSection->id)->with('success', 'Section Name And Course Name Updated Successfully');
        }

        if ($sectionNameChanged && $numberOfLecturesChanged  && $courseIdChanged) {
            $currentSection->update([
                'section_name' => $sectionRequest->section_name,
                'number_of_lectures' => $sectionRequest->number_of_lectures,
                'course_id' => $sectionRequest->course_id
            ]);
            return redirect()->route('admin.editSection', $currentSection->id)->with('success', 'All Section Data Updated');
        }

        if (!$sectionNameChanged && !$numberOfLecturesChanged && !$courseIdChanged) {
            return redirect()->route('admin.editSection', $currentSection->id)->with('error', 'No Changes');
        }
    }
    public function addSection(){
        $adminData = Admin::find(Auth::guard('admin')->id());
        $courses = Course::all();
        return view('admin.add.addSection',compact('courses','adminData'));
    }
    public function storeSection(StoreSectionRequest $storeSectionRequest){
        $adminId = Auth::guard('admin')->id();
        Section::create([
            'section_name'=>$storeSectionRequest->section_name,
            'number_of_lectures'=>$storeSectionRequest->number_of_lectures,
            'course_id'=>$storeSectionRequest->course_id,
            'admin_id'=>$adminId,
        ]);
        return redirect()->route('admin.addSection')->with('success','Section Created Successfully');
    }
}
