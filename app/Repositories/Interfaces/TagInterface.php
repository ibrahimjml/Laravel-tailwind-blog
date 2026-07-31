<?php

namespace App\Repositories\Interfaces;

use App\DTOs\PostFilterDTO;
use App\Models\Hashtag;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface TagInterface
{
    public function getBySearch(PostFilterDTO $dto, int $limit): Collection;

    public function getPostsByTag(Hashtag $hashtag, string $sorts, int $perpage, int $page): LengthAwarePaginator;

    public function getSliderImages(Hashtag $hashtag);
}
