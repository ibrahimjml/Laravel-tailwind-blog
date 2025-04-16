<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
  public function __invoke()
  {
    // dd(Cache::has('featuredPosts'), Cache::get('featuredPosts'));
    $featuredPosts = Cache::remember('featuredPosts', now()->addSeconds(20), function () {
      return Post::featured()->latest()->take(3)->get();
    
  });


  $trendingHashtag = Cache::remember('trendingHashtag', now()->addMinutes(2), function () {
    return Hashtag::withCount('posts')->orderByDesc('posts_count')->first();
});

$latestPosts = collect();

if ($trendingHashtag) {
    $latestPosts = Post::with(['user', 'hashtags'])
        ->withCount(['likes', 'comments'])
        ->whereHas('hashtags', function ($query) use ($trendingHashtag) {
            $query->where('hashtags.id', $trendingHashtag->id);
        })
        ->latest()
        ->take(3)
        ->get();
}



  return view('index', [
      'featuredPosts' => $featuredPosts,
      'latestPosts' => $latestPosts,
      'trendingHashtag' => $trendingHashtag

  ]);
    return view('index');
  }
}
