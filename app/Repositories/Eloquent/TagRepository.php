<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\TagInterface;

class TagRepository implements TagInterface
{
    public function getPostsByTag(\App\Models\Hashtag $hashtag)
    {
      return $hashtag->posts()
                     ->with(['user:id,username,avatar','hashtags:id,name,is_featured','categories:id,name,is_featured'])
                     ->withCount(['comments','likes'])
                     ->orderBy('created_at','desc')
                     ->simplepaginate(5);
    }
}
