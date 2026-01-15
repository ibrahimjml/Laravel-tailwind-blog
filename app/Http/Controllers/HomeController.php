<?php

namespace App\Http\Controllers;


use App\Models\Hashtag;
use App\Models\Post;
use App\Models\Slide;
use App\Repositories\Eloquent\PostRepository;
use App\Repositories\Interfaces\PostInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class HomeController extends Controller
{
  public function __invoke(PostInterface $repo)
  {
    $featuredPosts = $repo->getFeaturedPosts();


  $result = $repo->getTrendingTagPosts();
    

  return view('index', [
      'slides' => Slide::published()
                  ->latest()
                  ->get()
                  ->take(4),
      'featuredPosts' => $featuredPosts,
      'latestTrend' => $result['latestTrend'],
      'trendingHashtag' => $result['trendingHashtag']
       ]);

  }
}
