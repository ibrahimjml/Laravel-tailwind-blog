<?php

namespace App\Repositories\Caches;

use App\Models\Scraping\ScrapingSource;
use App\Repositories\Interfaces\NewsInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class NewsCacheDecorator implements NewsInterface
{
    public function __construct(private NewsInterface $repo){}
    public function getAllNewsWithSources()
    {
      $key = "latest-news";
      return Cache::remember($key, 900 , fn() => $this->repo->getAllNewsWithSources());
    }
    public function getLatestSources()
    {
      $key = "latest-sources";
      return Cache::remember($key, 900 , fn() => $this->repo->getLatestSources());
    }
    
    public function getPaginatedNews(string|null $sourceName, int $perpage, int $page): LengthAwarePaginator
    {
      $key = "news:{$sourceName}:perpage:{$perpage}:news-page:{$page}";
      return Cache::tags("news_paginated")->remember($key, 1800 , fn() => $this->repo->getPaginatedNews($sourceName,$perpage,$page));
    }
}