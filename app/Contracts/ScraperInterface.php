<?php 
namespace App\Contracts;

use App\Models\Scraping\ScrapingSource;

interface ScraperInterface
{
    public function scrape(ScrapingSource $source): void;
}