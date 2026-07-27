<?php

namespace App\Jobs;

use App\Factories\ScraperFactory;
use App\Models\Scraping\ScrapingSource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScrapeSourceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 300;
    public int $tries = 3;
 
    public function __construct(public ScrapingSource $source)
    {
      $this->onQueue('crawl');
    }

    public function handle(ScraperFactory $factory): void
    {
        $factory->make($this->source->type)->scrape($this->source);
    }
}
