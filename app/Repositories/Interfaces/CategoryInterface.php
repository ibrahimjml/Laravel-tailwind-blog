<?php

namespace App\Repositories\Interfaces;

use App\DTOs\PostFilterDTO;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface CategoryInterface
{
    public function getBySearch(PostFilterDTO $dto, int $limit): Collection;

    public function getPostsByCategory(Category $category, string $sorts, int $perpage, int $page): LengthAwarePaginator;

    public function getSliderImages(Category $category);
}
