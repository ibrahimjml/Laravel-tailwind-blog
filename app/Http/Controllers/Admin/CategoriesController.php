<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public  function __construct() {
    
    $this->middleware('permission:category.view')->only('categorypage');
    $this->middleware('permission:category.create')->only('create_category');
    $this->middleware('permission:category.update')->only('edit_category');
    $this->middleware('permission:category.delete')->only('delete_category');
    $this->middleware('permission:category.feature')->only('toggle_feature_category');
  }
    public function categorypage()
    {
      return view('admin.categories.categories',[
        'categories' => Category::paginate(7)
      ]);
    }
    public function create_category(Request $request)
    {
       $fields = $request->validate([
       'name' =>'required|string'
       ]);
      $category = Category::create($fields);
       return response()->json([
         'added'=>true,
         'message' =>"Category {$category->name} added !" 
       ]);
    }
      public function edit_category(Category $category, Request $request)
    {
        $fields = $request->validate([
    'name' =>'required|string'
    ]);
    $category->update($fields);
    return response()->json([
      'updated'=>true,
      'message' => "Updated to {$category->name}"
    ]);
    }
      public function delete_category(Category $category)
    {
      $name = $category->name;
      $category->delete();
    return response()->json([
      'deleted' => true,
      'message' => "Category {$name} deleted"
     ]);
    }

    public function toggle_feature_category(Category $category)
    {
       $category->update(['is_featured'=>!$category->is_featured]);
       if($category->is_featured){
         toastr()->success('category featured success',['timeOut'=>1000]);
       }else{
           toastr()->success('category unfeatured success',['timeOut'=>1000]);
       }
       return redirect()->back();
    }
}
