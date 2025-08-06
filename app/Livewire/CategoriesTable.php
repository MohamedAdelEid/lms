<?php

namespace App\Livewire;

use App\Models\Dashboard\Category;
use Illuminate\Database\QueryException;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CategoriesTable extends Component
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

    public function delete($categoryId)
    {
        $this->dispatch('confirmDelete', 
            id : $categoryId,
            message : 'Are you sure you want to delete this category?',
            title : 'Delete Category',
        );
    }

    #[On('delete')]
    public function deleteConfirmed($categoryId)
    {
        try {
            $category = Category::findOrFail($categoryId);
            $categoryName = $category->category_name;
            $category->delete();

            $this->dispatch('successDeleted', 
                message: "Category '{$categoryName}' deleted successfully!",
            );


        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                $this->dispatch('deleteFailed', 
                    message: "Cannot delete category because it is associated with existing courses."
                );
            } else {
                $this->dispatch('deleteFailed', 
                    message: "Database error occurred while deleting category."
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
        return view('livewire.categories-table', [
            'categories' => Category::search($this->search)->paginate($this->perPage)
        ]);
    }
}
