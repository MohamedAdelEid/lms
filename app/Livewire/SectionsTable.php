<?php

namespace App\Livewire;

use App\Models\Dashboard\Section;
use Illuminate\Database\QueryException;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class SectionsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function delete($sectionId)
    {
        $this->dispatch('confirmDelete',
            id : $sectionId,
            message : 'Are you sure you want to delete this section?',
            title : 'Delete Section',
        );
    }

    #[On('delete')]
    public function deleteConfirmed($sectionId)
    {
        try {
            $section = Section::findOrFail($sectionId);
            $sectionName = $section->section_name;
            $section->delete();

            $this->dispatch('successDeleted',
                message: "Section '{$sectionName}' deleted successfully!",
            );

        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                $this->dispatch('deleteFailed',
                    message: "Cannot delete section because it is associated with existing courses."
                );
            } else {
                $this->dispatch('deleteFailed',
                    message: "Database error occurred while deleting section."
                );
            }
        } catch (\Exception $e) {
            $this->dispatch('deleteFailed',
                message: "Unexpected error: " . $e->getMessage()
            );
        }
    }

    public function render()
    {
        $sections = Section::query()
            ->with(['course', 'admin', 'lectures'])
            ->when($this->search, function ($query) {
                $query->where('section_name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.sections-table', [
            'sections' => $sections
        ]);
    }
}
