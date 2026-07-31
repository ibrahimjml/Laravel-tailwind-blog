<?php

namespace App\Repositories\Caches;

use App\Models\Hashtag;
use App\Repositories\Interfaces\TagInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class TagCacheDecorator implements TagInterface
{
    public function __construct(private TagInterface $repo){}
      public function getBySearch($dto, int $limit): Collection
    {
        $key = sprintf('tags:search:%s:%d', md5(strtolower(trim($dto->search))), $limit);
        return Cache::tags(['tags_results'])->remember($key, now()->addMinutes(10),fn () => $this->repo->getBySearch($dto, $limit));
    }
    public function getPostsByTag(Hashtag $hashtag, $sorts, $perpage, $page): LengthAwarePaginator
    {
      $key = "tag:{$hashtag->name}:perpage:{$perpage}:hashtags-page:{$page}:sort:{$sorts}";
      return Cache::tags(["tag_posts_paginated"])->remember($key, 900 , fn() => $this->repo->getPostsByTag($hashtag,$sorts,$perpage,$page));
    }

    public function getSliderImages(Hashtag $hashtag)
    {
      $key = "tag-sliders{$hashtag}";
      return Cache::tags(["tag_posts_sliders"])->remember($key, 900 ,fn() => $this->repo->getSliderImages($hashtag));

    }
}
