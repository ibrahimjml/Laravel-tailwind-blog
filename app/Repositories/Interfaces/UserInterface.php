<?php

namespace App\Repositories\Interfaces;

use App\DTOs\PostFilterDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface UserInterface
{
   public function getBySearch(PostFilterDTO $dto, int $limit): Collection;
}