<?php

namespace App\Livewire;

use App\Models\Dashboard\Instructor;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithPagination;

class InstructorsTable extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 5;
    public function delete(Instructor $instructor)
    {
        try {
            $instructor->delete();
            $this->dispatch(
                'alert',
                position: 'center',
                timer: 5000,
                toas: true,
                text: 'Instructor Deleted Successfully',
                showConfirmButton: true,
                onConfirmed: '',
                width: '300',
            );
        } catch (QueryException $e) {
            if ($e->errorInfo[1] === 1451) {
                $this->dispatch(
                    'alert',
                    position: 'center',
                    timer: 6000,
                    toas: true,
                    text: 'Cannot delete Instructor. This Instructor is associated with other Courses.',
                    showConfirmButton: true,
                    onConfirmed: '',
                    width: '400',
                );
            } else {
                $this->dispatch(
                    'alert',
                    position: 'center',
                    timer: 5000,
                    toas: true,
                    text: 'An error occurred while deleting the Instructor',
                    showConfirmButton: true,
                    onConfirmed: '',
                    width: '300',
                );
            }
        }
    }

    public function viewImg($image)
    {
        $this->dispatch(
            'view-image',
            position: 'center',
            toas: true,
            text: "/images/instructors/" . $image,
            showConfirmButton: true,
            onConfirmed: '',
            width: '300',
        );
    }


    public function render()
    {
        return view('livewire.instructors-table', [
            'instructors' => Instructor::search($this->search)->paginate($this->perPage)
        ]);
    }
}
