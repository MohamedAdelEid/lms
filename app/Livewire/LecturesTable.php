<?php

namespace App\Livewire;

use App\Models\Dashboard\Lecture;
use Illuminate\Database\QueryException;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class LecturesTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;
    
    // Modal properties
    public $showImageModal = false;
    public $showDescriptionModal = false;
    public $showVideoModal = false;
    public $modalImage = '';
    public $modalDescription = '';
    public $modalTitle = '';
    public $modalVideoData = [];

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function delete($lectureId){
        $this->dispatch('confirmDelete',
            id: $lectureId,
            message: 'Are you sure you want to delete this lecture?',
            title: 'Delete Lecture',
        );
    }

    #[On('delete')]
    public function deleteConfirmed($lectureId)
    {
        try {
            $lecture = Lecture::with('videos')->findOrFail($lectureId);
            $lectureName = $lecture->lecture_name;
            
            foreach ($lecture->videos as $video) {
                $video->delete();
            }
            
            $lecture->delete();

            $this->dispatch('successDeleted',
                message: "Lecture '{$lectureName}' deleted successfully!",
            );

        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                $this->dispatch('deleteFailed',
                    message: "Cannot delete lecture because it is associated with existing videos."
                );
            } else {
                $this->dispatch('deleteFailed',
                    message: "Database error occurred while deleting lecture."
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
        $this->modalImage = "/images/VideoCoverImages/" . $image;
        $this->modalTitle = $title;
        $this->showImageModal = true;
    }

    public function viewDescription($description, $title)
    {
        $this->modalDescription = $description;
        $this->modalTitle = $title;
        $this->showDescriptionModal = true;
    }

    public function viewVideo($lectureId)
    {
        $lecture = Lecture::with('videos')->find($lectureId);
        if ($lecture && $lecture->videos->isNotEmpty()) {
            $this->modalTitle = $lecture->lecture_name;
            $this->modalVideoData = [
                'lecture_id' => $lectureId,
                'lecture_name' => $lecture->lecture_name,
                'videos' => $lecture->videos->toArray()
            ];
            $this->showVideoModal = true;
        }
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

    public function closeVideoModal()
    {
        $this->showVideoModal = false;
        $this->modalVideoData = [];
        $this->modalTitle = '';
    }

    public function render()
    {
        $lectures = Lecture::query()
            ->with(['section', 'admin', 'videos'])
            ->when($this->search, function($query) {
                $query->where('lecture_name', 'like', '%' . $this->search . '%')
                      ->orWhere('lecture_description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.lectures-table', [
            'lectures' => $lectures
        ]);
    }
}
