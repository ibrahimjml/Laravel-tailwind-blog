<?php

namespace App\Repositories\Caches;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CategoryCacheDecorator implements CategoryInterface
{
    public function __construct(private CategoryInterface $repo){}
    public function getBySearch($dto, int $limit): Collection
    {
        $key = sprintf('categories:search:%s:%d', md5(strtolower(trim($dto->search))), $limit);
        return Cache::tags(['categories_type_results'])->remember($key, now()->addMinutes(10),fn () => $this->repo->getBySearch($dto, $limit));
    }
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
