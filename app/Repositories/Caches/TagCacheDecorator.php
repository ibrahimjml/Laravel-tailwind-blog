<?php

namespace App\Repositories\Caches;

use App\Repositories\Interfaces\TagInterface;
use Illuminate\Support\Facades\Cache;

class TagCacheDecorator implements TagInterface
{
    public function __construct(private TagInterface $repo){}
    public function getPostsByTag(\App\Models\Hashtag $hashtag)
    {
      $page = request('page',1);
      $key = "tag:{$hashtag->name}:published:page:{$page}";
      return Cache::tags(["tags"])->remember($key, 900 , fn() => $this->repo->getPostsByTag($hashtag));
    }

    
}
