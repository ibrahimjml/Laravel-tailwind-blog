<?php 
namespace App\Factories;


use App\Contracts\ScraperInterface;
use App\Enums\ScrapingType;
use App\Services\Scraping\RssScraperService;
use App\Services\Scraping\WebScraperService;
class ScraperFactory
{
    public function __construct(
        protected WebScraperService $web,
        protected RssScraperService $rss,
    ) {
    }

    public function make(ScrapingType $type): ScraperInterface
    {
        return match ($type) {

            ScrapingType::WEB => $this->web,

            ScrapingType::RSS => $this->rss,

        };
    }
}