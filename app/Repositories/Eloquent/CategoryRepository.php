<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\CategoryInterface;

class CategoryRepository implements CategoryInterface
{
    public function getPostsByCategory(\App\Models\Category $category)
    {
      return $category->posts()
             ->with(['user:id,username,avatar','categories:id,name'])
             ->withCount(['comments','likes'])
             ->orderBy('created_at','desc')
             ->simplepaginate(5);
    }
}
