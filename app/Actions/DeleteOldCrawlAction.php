<?php

namespace App\Actions;

use App\Models\Scraping\ScrapedPost;
use App\Models\Scraping\ScrapingSource;

class DeleteOldCrawlAction
{
     public function delete(ScrapingSource $source): int
    {
        $maxAge = now()->subHours($source->max_age_hours);
        
        return ScrapedPost::where('scraping_source_id', $source->id)
            ->where('last_scraped_at', '<', $maxAge)
            ->delete();
    }
}
