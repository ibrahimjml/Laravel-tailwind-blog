<?php

namespace App\Repositories\Caches;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class CategoryCacheDecorator implements CategoryInterface
{
    public function __construct(private CategoryInterface $repo){}
    public function getPostsByCategory(Category $category, $sorts, $perpage, $page): LengthAwarePaginator
    {
      $key = "category:{$category->name}:perpage:{$perpage}:catgeories-page:{$page}:sort:{$sorts}";
      return Cache::tags("category_posts_paginated")->remember($key, 900 ,fn() => $this->repo->getPostsByCategory($category,$sorts,$perpage,$page));
    }
    public function getSliderImages(Category $category)
    {
      $key = "category-sliders{$category}";
      return Cache::tags("category_posts_sliders")->remember($key, 900 ,fn() => $this->repo->getSliderImages($category));

    }
}
