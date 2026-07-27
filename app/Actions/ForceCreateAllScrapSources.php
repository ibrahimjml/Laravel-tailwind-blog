<?php

namespace App\Actions;

use App\Jobs\ScrapeSourceJob;
use App\Models\Scraping\ScrapingSource;

class ForceCreateAllScrapSources
{
    public function execute()
    {
      $sources = ScrapingSource::active()->get();

        foreach ($sources as $source) {
            ScrapeSourceJob::dispatch($source);
        }

        $message = $sources->isEmpty()
            ? 'No active scraping sources found.'
            : "Crawl started for {$sources->count()} active sources in background";

        return [
          'message' => $message
        ];    
    }
}
