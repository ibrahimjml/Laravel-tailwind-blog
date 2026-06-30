<?php

namespace App\Repositories\Eloquent;

use App\Models\Hashtag;
use App\Repositories\Interfaces\TagInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TagRepository implements TagInterface
{
    public function getPostsByTag(Hashtag $hashtag, $sorts, $perpage, $page): LengthAwarePaginator
    {
      return $hashtag->posts()
                     ->with(['user:id,username,avatar','hashtags:id,name,is_featured','categories:id,name,is_featured'])
                     ->withCount(['totalcomments','likes'])
                     ->blogSort($sorts)
                     ->orderBy('created_at','desc')
                     ->paginate($perpage,['*'],'hashtags_page',$page)
                     ->withQueryString();
    }

    public function getSliderImages(Hashtag $hashtag)
    {
        return $hashtag->posts()
                        ->select([
                            'posts.id',
                            'posts.title',
                            'posts.image_path',
                        ])
                        ->latest('posts.created_at')
                        ->take(5)
                        ->get();
    }
}
