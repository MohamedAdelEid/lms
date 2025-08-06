<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\Dashboard\Category;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.dashboard', compact('categories'));
    }
    public  function viewEditCategory($id){
        $adminData = Admin::find(Auth::guard('admin')->id());
        $currentCategoryData = Category::find($id);
        if (!$currentCategoryData) {
            return redirect()->route('admin.editCategory')->with('error', 'Category Not Found');
        }
        return view('admin.editPages.editCategory',compact('currentCategoryData','adminData'));
    }
    public function editCategory(Request $request, $id){
        $request->validate([
            'category_name' => 'required|string|regex:/^[\pL\s\-]+$/u|max:100',
        ], [
            'category_name.required' => 'Please Enter Category Name',
            'category_name.string' => 'Please Enter Text',
            'category_name.regex' => 'Please Enter Text Only',
            'category_name.max' => 'Please Enter Shortest Text',
        ]);

        $currentCategory = Category::find($id);

        if (!$currentCategory) {
            return redirect()->route('admin.editCategory')->with('error', 'Category Not Found');
        }

        $currentCategory->update([
            'category_name' => $request->category_name
        ]);

        return redirect()->route('admin.editCategory',$currentCategory->id)->with('success', 'Category Updated successfully');
    }
    public function addCategory(){
        $adminData = Admin::find(Auth::guard('admin')->id());
        return view('admin.add.addCategory',compact('adminData'));
    }
    public function storeCategory(Request $request){
        $request->validate([
            'category_name' => 'required|string|regex:/^[\pL\s\-]+$/u|max:100',
        ],[
            'category_name.required' => 'Please Enter Category Name',
            'category_name.string' => 'Please Enter Text',
            'category_name.regex' => 'Please Enter Text Only',
            'category_name.max' => 'Please Enter Shortest Text',
        ]);
        $categoryName = $request->category_name;
        $existingCategory = Category::where('category_name',$categoryName)->first();
        if($existingCategory){
            return redirect()->route('admin.addCategory')->with('error','Category Already Exists.');
        }
        Category::create([
            'category_name'=>$request->category_name
        ]);
        return redirect()->route('admin.addCategory')->with('success', 'Category added successfully.');

    }
    public function show()
    {
        $adminData = Admin::find(Auth::guard('admin')->id());
        return view('admin.view.viewCategories',compact('adminData'));
    }
}
