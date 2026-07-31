<?php

namespace App\Repositories\Interfaces;

use App\DTOs\PostFilterDTO;
use App\Models\Hashtag;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface NewsInterface
{
    public function getBySearch(PostFilterDTO $dto, int $limit): Collection;
    public function getPaginatedNews(?string $sourceName, int $perpage, int $page): LengthAwarePaginator;
    public function getAllNewsWithSources();

    public function getLatestSources();
}