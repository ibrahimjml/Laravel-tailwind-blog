<?php

namespace App\Repositories\Interfaces;

use App\Models\Category;

interface CategoryInterface
{
    public function getPostsByCategory(Category $category);
}
