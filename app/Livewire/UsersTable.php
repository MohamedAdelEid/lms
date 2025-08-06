<?php

namespace App\Livewire;

use App\Models\User\User;
use App\Models\Dashboard\Course;
use App\Models\Dashboard\Section;
use App\Models\UserCourse;
use App\Models\UserCourseSection;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class UsersTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;
    
    // Bulk operations
    public $selectedUsers = [];
    public $selectAll = false;
    
    // Modal properties
    public $showImageModal = false;
    public $showBulkAssignModal = false;
    public $modalImage = '';
    public $modalTitle = '';
    
    // Bulk assignment properties
    public $selectedCourses = [];
    public $courseSections = [];
    public $selectedSections = [];

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
        $this->selectedUsers = [];
        $this->selectAll = false;
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedUsers = $this->getUsers()->pluck('id')->toArray();
        } else {
            $this->selectedUsers = [];
        }
    }

    public function updatedSelectedUsers()
    {
        $this->selectAll = count($this->selectedUsers) === $this->getUsers()->count();
    }

    // Delete system using the unified approach
    public function delete($userId)
    {
        $this->dispatch('confirmDelete', 
            id: $userId, 
            message: 'Are you sure you want to delete this user?',
            title: 'Delete User'
        );
    }

    #[On('delete')]
    public function deleteConfirmed($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $userName = $user->name;
            $user->delete();
            
            $this->dispatch('successDeleted', 
                message: "User '{$userName}' deleted successfully!"
            );
            
            // Remove from selected users if it was selected
            $this->selectedUsers = array_diff($this->selectedUsers, [$userId]);
            
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                $this->dispatch('deleteFailed', 
                    message: "Cannot delete user because they are associated with existing courses."
                );
            } else {
                $this->dispatch('deleteFailed', 
                    message: "Database error occurred while deleting user."
                );
            }
        } catch (\Exception $e) {
            $this->dispatch('deleteFailed', 
                message: "Unexpected error: " . $e->getMessage()
            );
        }
    }

    public function toggleBlockUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['is_blocked' => !$user->is_blocked]);
        
        $message = $user->is_blocked ? 'User blocked successfully!' : 'User unblocked successfully!';
        
        $this->dispatch('alert', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
            'text' => $message,
            'showConfirmButton' => false,
            'icon' => 'success',
            'width' => '300px'
        ]);
    }

    public function viewImage($image, $name)
    {
        $this->modalImage = "/images/users/" . $image;
        $this->modalTitle = $name;
        $this->showImageModal = true;
    }

    public function closeImageModal()
    {
        $this->showImageModal = false;
        $this->modalImage = '';
        $this->modalTitle = '';
    }

    public function copyEmail($email)
    {
        $this->dispatch('copyToClipboard', email: $email);
    }

    // Bulk operations
    public function bulkBlock()
    {
        if (empty($this->selectedUsers)) {
            $this->dispatch('alert', [
                'icon' => 'warning',
                'title' => 'No Selection',
                'text' => 'Please select users first.',
                'timer' => 3000
            ]);
            return;
        }

        User::whereIn('id', $this->selectedUsers)->update(['is_blocked' => true]);
        
        $count = count($this->selectedUsers);
        $this->dispatch('alert', [
            'icon' => 'success',
            'title' => 'Success!',
            'text' => "{$count} users blocked successfully!",
            'timer' => 3000
        ]);
        
        $this->selectedUsers = [];
        $this->selectAll = false;
    }

    public function bulkUnblock()
    {
        if (empty($this->selectedUsers)) {
            $this->dispatch('alert', [
                'icon' => 'warning',
                'title' => 'No Selection',
                'text' => 'Please select users first.',
                'timer' => 3000
            ]);
            return;
        }

        User::whereIn('id', $this->selectedUsers)->update(['is_blocked' => false]);
        
        $count = count($this->selectedUsers);
        $this->dispatch('alert', [
            'icon' => 'success',
            'title' => 'Success!',
            'text' => "{$count} users unblocked successfully!",
            'timer' => 3000
        ]);
        
        $this->selectedUsers = [];
        $this->selectAll = false;
    }

    public function bulkDelete()
    {
        if (empty($this->selectedUsers)) {
            $this->dispatch('alert', [
                'icon' => 'warning',
                'title' => 'No Selection',
                'text' => 'Please select users first.',
                'timer' => 3000
            ]);
            return;
        }

        $count = count($this->selectedUsers);
        $this->dispatch('confirmBulkDelete', 
            ids: $this->selectedUsers,
            message: "Are you sure you want to delete {$count} selected users?",
            title: 'Bulk Delete Users'
        );
    }

    #[On('bulkDelete')]
    public function bulkDeleteConfirmed($ids)
    {
        try {
            $deletedCount = User::whereIn('id', $ids)->count();
            User::whereIn('id', $ids)->delete();
            
            $this->dispatch('successDeleted', 
                message: "{$deletedCount} users deleted successfully!"
            );
            
            $this->selectedUsers = [];
            $this->selectAll = false;
            
        } catch (QueryException $e) {
            $this->dispatch('deleteFailed', 
                message: "Some users could not be deleted due to existing associations."
            );
        }
    }

    public function openBulkAssignModal()
    {
        if (empty($this->selectedUsers)) {
            $this->dispatch('alert', [
                'icon' => 'warning',
                'title' => 'No Selection',
                'text' => 'Please select users first.',
                'timer' => 3000
            ]);
            return;
        }

        $this->showBulkAssignModal = true;
        $this->loadCoursesForAssignment();
    }

    public function closeBulkAssignModal()
    {
        $this->showBulkAssignModal = false;
        $this->selectedCourses = [];
        $this->courseSections = [];
        $this->selectedSections = [];
    }

    public function loadCoursesForAssignment()
    {
        $courses = Course::with('sections')->get();
        $this->courseSections = [];
        
        foreach ($courses as $course) {
            $this->courseSections[$course->id] = [
                'course' => $course,
                'sections' => $course->sections,
                'selected_sections' => []
            ];
        }
    }

    public function updatedSelectedCourses()
    {
        // Reset sections when courses change
        foreach ($this->courseSections as $courseId => $data) {
            if (!in_array($courseId, $this->selectedCourses)) {
                $this->courseSections[$courseId]['selected_sections'] = [];
            }
        }
    }

    public function toggleAllSections($courseId)
    {
        if (!isset($this->courseSections[$courseId])) return;
        
        $sections = $this->courseSections[$courseId]['sections'];
        $currentSelected = $this->courseSections[$courseId]['selected_sections'] ?? [];
        
        if (count($currentSelected) === count($sections)) {
            // All selected, deselect all
            $this->courseSections[$courseId]['selected_sections'] = [];
        } else {
            // Not all selected, select all
            $this->courseSections[$courseId]['selected_sections'] = $sections->pluck('id')->toArray();
        }
    }

    public function assignCoursesToUsers()
    {
        if (empty($this->selectedCourses)) {
            $this->dispatch('alert', [
                'icon' => 'warning',
                'title' => 'No Courses Selected',
                'text' => 'Please select at least one course.',
                'timer' => 3000
            ]);
            return;
        }

        $assignmentCount = 0;
        
        foreach ($this->selectedUsers as $userId) {
            foreach ($this->selectedCourses as $courseId) {
                $selectedSections = $this->courseSections[$courseId]['selected_sections'] ?? [];
                
                if (!empty($selectedSections)) {
                    // Create user course record
                    UserCourse::firstOrCreate([
                        'user_id' => $userId,
                        'course_id' => $courseId
                    ]);
                    
                    // Assign sections
                    foreach ($selectedSections as $sectionId) {
                        UserCourseSection::firstOrCreate([
                            'user_id' => $userId,
                            'course_id' => $courseId,
                            'section_id' => $sectionId
                        ]);
                        $assignmentCount++;
                    }
                }
            }
        }

        $userCount = count($this->selectedUsers);
        $this->dispatch('alert', [
            'icon' => 'success',
            'title' => 'Success!',
            'text' => "Courses assigned to {$userCount} users successfully! ({$assignmentCount} section assignments)",
            'timer' => 4000
        ]);

        $this->closeBulkAssignModal();
        $this->selectedUsers = [];
        $this->selectAll = false;
    }

    private function getUsers()
    {
        return User::query()
            ->with(['admin', 'courses.sections'])
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('phone_number', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc');
    }

    public function render()
    {
        $users = $this->getUsers()->paginate($this->perPage);
        $courses = Course::with('sections')->get();

        return view('livewire.users-table', [
            'users' => $users,
            'courses' => $courses
        ]);
    }
}
