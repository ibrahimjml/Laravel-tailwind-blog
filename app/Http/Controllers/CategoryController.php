<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckIfBlocked;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
class CategoryController extends Controller
{
    public function __construct()
  {
    $this->middleware(['auth','verified',CheckIfBlocked::class]);
  }

    public function viewcategory(Category $category):View
    {

    $posts = $category->posts()
             ->with(['user:id,username,avatar','categories:id,name'])
             ->withCount(['comments','likes'])
             ->orderBy('created_at','desc')
             ->simplepaginate(5);

      return view('categories.show', [
        'posts' => $posts,
        'currentCategory' => $category,
      ]);
    }
}
