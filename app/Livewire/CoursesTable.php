<?php

namespace App\Livewire;

use App\Models\Dashboard\Course;
use Illuminate\Database\QueryException;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CoursesTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;

    // Modal properties
    public $showImageModal = false;
    public $showDescriptionModal = false;
    public $modalImage = '';
    public $modalDescription = '';
    public $modalTitle = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function delete($courseId)
    {
        $this->dispatch('confirmDelete',
            id: $courseId,
            message: 'Are you sure you want to delete this course?',
            title: 'Delete Course',
        );
    }

    #[On('delete')]
    public function deleteConfirmed($courseId)
    {
        try {
            $course = Course::findOrFail($courseId);
            $courseName = $course->course_title;
            $course->delete();

            $this->dispatch('successDeleted',
                message: "Course '{$courseName}' deleted successfully!",
            );

        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                $this->dispatch('deleteFailed',
                    message: "Cannot delete course because it is associated with existing sections or lectures."
                );
            } else {
                $this->dispatch('deleteFailed',
                    message: "Database error occurred while deleting course."
                );
            }
        } catch (\Exception $e) {
            $this->dispatch('deleteFailed',
                message: "Unexpected error: " . $e->getMessage()
            );
        }
    }


    public function viewImage($image, $title)
    {
        $this->modalImage = "/images/CoursesCoverImages/" . $image;
        $this->modalTitle = $title;
        $this->showImageModal = true;
    }

    public function viewDescription($description, $title)
    {
        $this->modalDescription = $description;
        $this->modalTitle = $title;
        $this->showDescriptionModal = true;
    }

    public function closeImageModal()
    {
        $this->showImageModal = false;
        $this->modalImage = '';
        $this->modalTitle = '';
    }

    public function closeDescriptionModal()
    {
        $this->showDescriptionModal = false;
        $this->modalDescription = '';
        $this->modalTitle = '';
    }

    public function render()
    {
        $courses = Course::query()
            ->with(['instructor', 'admin', 'category', 'sections'])
            ->when($this->search, function ($query) {
                $query->where('course_title', 'like', '%' . $this->search . '%')
                    ->orWhere('course_description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.courses-table', [
            'courses' => $courses
        ]);
    }
}
