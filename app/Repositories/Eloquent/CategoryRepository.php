<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryRepository implements CategoryInterface
{
    public function getPostsByCategory(Category $category, $sorts, $perpage, $page): LengthAwarePaginator
    {
      return $category->posts()
                      ->with(['user:id,username,avatar','categories:id,name'])
                      ->withCount(['totalcomments','likes'])
                      ->blogSort($sorts)
                      ->orderBy('created_at','desc')
                      ->paginate($perpage,['*'],'categories_page',$page)
                      ->withQueryString();
    }
    public function getSliderImages(Category $category)
    {
        return $category->posts()
                        ->select([
                            'posts.id',
                            'posts.title',
                            'posts.image_path',
                        ])
                        ->latest('posts.created_at')
                        ->take(5)
                        ->get();
    }
}
