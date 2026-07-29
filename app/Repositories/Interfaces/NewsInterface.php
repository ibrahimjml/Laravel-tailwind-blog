<?php

namespace App\Repositories\Interfaces;

use App\Models\Hashtag;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface NewsInterface
{
    public function getPaginatedNews(?string $sourceName, int $perpage, int $page): LengthAwarePaginator;
    public function getAllNewsWithSources();

    public function getLatestSources();
}