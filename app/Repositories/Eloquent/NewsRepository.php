<?php

namespace App\Repositories\Eloquent;

use App\Models\Scraping\ScrapedPost;
use App\Models\Scraping\ScrapingSource;
use App\Repositories\Interfaces\NewsInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class NewsRepository implements NewsInterface
{
  public function getPaginatedNews(string|null $sourceName, int $perpage, int $page): LengthAwarePaginator
  {
    return ScrapedPost::query()
      ->with('source')
      ->latest()
      ->when($sourceName, function ($query, $sourceName) {
        return $query->whereHas('source', function ($sub) use ($sourceName) {
          $sub->where('name', $sourceName);
        });
      })
      ->paginate($perpage, ['*'], 'news_page', $page)
      ->withQueryString();
  }
  public function getAllNewsWithSources()
  {
    $latestNews = ScrapedPost::query()
      ->with('source')
      ->whereHas('source', function ($q) {
        $q->where('name', 'Cnn');
      })
      ->latest()
      ->take(4)
      ->get();

    $excludeIds = $latestNews->pluck('id');

    $moreNews = ScrapingSource::query()
      ->active()
      ->take(3)
      ->get()
      ->flatMap(function (ScrapingSource $source) use ($excludeIds) {
        return ScrapedPost::query()
          ->with('source')
          ->where('scraping_source_id', $source->id)
          ->whereNotIn('id', $excludeIds)
          ->latest()
          ->take(1)
          ->get();
      })
      ->sortByDesc('created_at')
      ->values();

    return [
      'latestNews' => $latestNews,
      'moreNews' => $moreNews,
    ];
  }

  public function getLatestSources()
  {
    return ScrapingSource::query()
      ->withCount('scrapedData as posts_count')
      ->active()
      ->latest()
      ->take(4)
      ->get();

  }

}