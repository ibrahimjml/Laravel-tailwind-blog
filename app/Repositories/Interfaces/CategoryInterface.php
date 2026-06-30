<?php

namespace App\Repositories\Interfaces;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CategoryInterface
{
    public function getPostsByCategory(Category $category, string $sorts, int $perpage, int $page): LengthAwarePaginator;

    public function getSliderImages(Category $category);
}
