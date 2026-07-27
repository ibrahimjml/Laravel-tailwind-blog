<?php

namespace App\Http\Controllers;


use App\Models\Slide;
use App\Repositories\Interfaces\NewsInterface;
use App\Repositories\Interfaces\PostInterface;


class HomeController extends Controller
{
  public function __invoke(PostInterface $repo, NewsInterface $news)
  {
    $featuredPosts = $repo->getFeaturedPosts();
    $news = $news->getAllNewsWithSources();
    $result = $repo->getTrendingTagPosts();
    

  return view('index', [
      'slides' => Slide::published()
                  ->latest()
                  ->get()
                  ->take(4),
      'featuredPosts' => $featuredPosts,
      'latestTrend' => $result['latestTrend'],
      'trendingHashtag' => $result['trendingHashtag'],
       'latestNews' => $news['latestNews'],
       'moreNews' => $news['moreNews'],
       ]);

  }
}
