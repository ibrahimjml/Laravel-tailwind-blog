<?php

namespace App\Repositories\Interfaces;

use App\Models\Hashtag;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TagInterface
{
    public function getPostsByTag(Hashtag $hashtag, string $sorts, int $perpage, int $page): LengthAwarePaginator;

    public function getSliderImages(Hashtag $hashtag);
}
