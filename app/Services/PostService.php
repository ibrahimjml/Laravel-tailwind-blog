<?php

namespace App\Services;

use App\Models\Hashtag;
use Illuminate\Database\Eloquent\Builder;

class PostService
{
    public function sortedPosts(Builder $query, string $sortoption = 'latest'){
        switch ($sortoption) {
      case 'latest':
        $query->latest();
        break;

      case 'oldest':
        $query->oldest();
        break;

      case 'mostliked':
        $query->orderByDesc('likes_count');
        break;

        case 'followings':
        $followings = auth()->user()->followings->pluck('id');
        $query->whereIn('user_id',$followings);
          break;

        case 'featured':
          $query->featured();
          break;

      case 'hashtagtrend':

        $trendingHashtag = Hashtag::withCount('posts')
          ->having('posts_count','>',0)
          ->orderByDesc('posts_count')
          ->first();

        if ($trendingHashtag) {

          $query->whereHas('hashtags', function ($query) use ($trendingHashtag) {
            $query->where('hashtags.id', $trendingHashtag->id);
          });
        } else {

          $query->whereRaw('0 = 1');
        }
        break;

      default:
        $query->latest();
        break;
    }
    return $query;
}
}
