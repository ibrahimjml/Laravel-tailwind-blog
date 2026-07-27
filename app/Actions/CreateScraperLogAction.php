<?php

namespace App\Actions;

use App\Models\Scraping\ScrapingLog;
use App\Models\Scraping\ScrapingSource;

class CreateScraperLogAction
{
    public function create(ScrapingSource $source, string $level, string $message)
    {
       ScrapingLog::create([
            'scraping_source_id' => $source->id,
            'level' => $level,
            'message' => $message,
        ]);
    }
}
