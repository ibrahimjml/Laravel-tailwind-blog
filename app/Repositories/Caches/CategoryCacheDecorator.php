<?php

namespace App\Repositories\Caches;

use App\Repositories\Interfaces\CategoryInterface;
use Illuminate\Support\Facades\Cache;

class CategoryCacheDecorator implements CategoryInterface
{
    public function __construct(private CategoryInterface $repo){}
    public function getPostsByCategory(\App\Models\Category $category)
    {
      $key = "category:{$category->name}:published";
      return Cache::tags("category:published")->remember($key, 900 ,fn() => $this->repo->getPostsByCategory($category));
    }
}
