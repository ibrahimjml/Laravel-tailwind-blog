<?php

namespace App\Http\Controllers;


use App\Models\Hashtag;
use App\Models\Post;
use App\Models\Slide;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class HomeController extends Controller
{
  public function __invoke()
  {
    $featuredPosts = Cache::remember('featuredPosts', now()->addSeconds(20), function () {
      return Post::published()
                ->featured()
                ->withCount( 'totalcomments')
                ->latest()
                ->take(7)
                ->get();
    
  });


  $trendingHashtag = Cache::remember('trendingHashtag', now()->addMinutes(2), function () {
    return Hashtag::active()
              ->withCount('posts')
              ->orderByDesc('posts_count')
              ->first();
});

$oldestPosts = collect();

if ($trendingHashtag) {
    $oldestPosts = Post::published()
        ->with(['user', 'hashtags','comments'])
        ->withCount('totalcomments')
        ->whereHas('hashtags', function ($query) use ($trendingHashtag) {
            $query->where('hashtags.id', $trendingHashtag->id);
        })
        ->oldest()
        ->take(3)
        ->get();
}

  return view('index', [
      'slides' => Slide::published()
                  ->latest()
                  ->get()
                  ->take(4),
      'featuredPosts' => $featuredPosts,
      'oldestPosts' => $oldestPosts,
      'trendingHashtag' => $trendingHashtag
       ]);

  }
}
