<?php

namespace App\Services\Scraping;

use App\Actions\CreateScraperLogAction;

use App\Actions\DeleteOldCrawlAction;
use App\Contracts\ScraperInterface;
use App\Models\Scraping\ScrapedPost;
use App\Models\Scraping\ScrapingSource;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\DomCrawler\Crawler;


class WebScraperService implements ScraperInterface
{
    // blocked segments 'navlinks'
    protected array $blockedFirstSegments = [
        'videos', 'video', 'live-news', 'weather', 'about', 'about-us', 'contact',
        'privacy', 'terms', 'newsletters', 'newsletter', 'sitemap', 'search',
        'subscribe', 'account', 'login', 'signup', 'app', 'audio', 'podcasts',
    ];
    protected array $allowedOgTypes = ['article', 'news', 'blog', 'website'];
    public function __construct(
        protected Client $client,
        protected CreateScraperLogAction $log,
        protected DeleteOldCrawlAction $deleteOldCrawls
      ){
        $this->client = $client;
       }

public function scrape(ScrapingSource $source): void
{
    $this->log->create($source, 'info', "Starting crawl for {$source->name} ({$source->url})");
    // delete old crawls
    try {
        $deleted = $this->deleteOldCrawls->delete($source);
        if($deleted > 0){
          $this->log->create($source, 'info', "Deleted {$deleted} article(s) older than {$source->max_age_hours}h.");
        }
    } catch (\Throwable $e) {
        $this->log->create($source,'error',"pruneOldCrawls failed: {$e->getMessage()} in {$e->getFile()}:{$e->getLine()}");
    }
        
    // fetching
    try {
        $html = $this->fetch($source->url);
    } catch (GuzzleException $e) {
        $this->log->create($source, 'error', "Failed to fetch source URL: {$e->getMessage()}");
        return;
    }
    // extract links
    $links = $this->extractLinks($html, $source->url, $source->max_links);

    if (empty($links)) {
        $this->log->create($source,'warning','No article-shaped links found on source page (only nav/section pages matched).');

        $source->update(['last_run_at' => now()]);
        return;
    }

    $newLinks = [];

    foreach ($links as $link) {
        if (! ScrapedPost::where('link_hash', md5($link))->exists()) {
            $newLinks[] = $link;
        }
    }

    $this->log->create($source,'info','Found ' . count($newLinks) . ' new article links. Extracting OpenGraph data...');

    if (empty($newLinks)) {
        $this->log->create($source, 'success', 'No new articles found.');
        $source->update(['last_run_at' => now()]);
        return;
    }

    $saved = 0;
    $skipped = 0;
    $rejectedNonArticle = 0;

    foreach ($newLinks as $link) {

        $linkHash = md5($link);

        try {
            $og = $this->extractOpenGraph($link);
        } catch (GuzzleException $e) {
            $this->log->create($source, 'warning', "Failed to fetch {$link}: {$e->getMessage()}");
            continue;
        }

        if (empty($og)) {
            $rejectedNonArticle++;
            continue;
        }

        if ($source->skip_no_image && empty($og['image'])) {
            $skipped++;
            continue;
        }

        if ($source->skip_no_category && empty($og['category'])) {
            $skipped++;
            continue;
        }

         ScrapedPost::create([
            'scraping_source_id' => $source->id,
            'link_hash' => $linkHash,
            'link' => $link,
            'title' => $og['title'] ?? null,
            'description' => $og['description'] ?? null,
            'category' => $og['category'] ?? null,
            'image_url' => $og['image'] ?? null,
            'last_scraped_at' => now()
        ]);

        $saved++;
    }

    $this->log->create($source,'success',"Crawl finished. Saved {$saved} new items, skipped {$skipped} (image/category rule), rejected {$rejectedNonArticle} (not an article).");

    $source->update(['last_run_at' => now()]);
}

    protected function fetch(string $url): string
    {
        $response = $this->client->get($url);
        return (string) $response->getBody();
    }

    protected function extractLinks(string $html, string $baseUrl, int $maxLinks): array
    {
        $crawler = new Crawler($html, $baseUrl);
        $host = parse_url($baseUrl, PHP_URL_HOST);

        $links = [];

        $crawler->filter('a')->each(function (Crawler $node) use (&$links, $host) {
            $href = $node->attr('href');
            if (!$href) {
                return;
            }

            $absolute = $this->resolveUrl($href, $node);
            if (!$absolute) {
                return;
            }

            $linkHost = parse_url($absolute, PHP_URL_HOST);
            if ($linkHost !== $host) {
                return; // stay on the same domain
            }

            // Drop fragments and query strings so variants of the same article dedupe
            $clean = strtok($absolute, '#');
            $clean = strtok($clean, '?') ?: $clean;

            if (!$this->looksLikeArticle($clean)) {
                return;
            }

            $links[$clean] = true; // dedupe while preserving order via keys
        });

        return array_slice(array_keys($links), 0, $maxLinks);
    }

    protected function looksLikeArticle(string $url): bool
    {
        $path = trim(parse_url($url, PHP_URL_PATH) ?? '', '/');

        if ($path === '') {
            return false; // homepage 
        }

        $segments = explode('/', $path);

        if (count($segments) < 2) {
            return false; // bare sections
        }

        if (in_array(strtolower($segments[0]), $this->blockedFirstSegments, true)) {
            return false;
        }

        $slug = end($segments);

        // Article slugs hyphenated
        return strlen($slug) > 15 && str_contains($slug, '-');
    }

    protected function resolveUrl(string $href, Crawler $node): ?string
    {
        if (str_starts_with($href, 'http://') || str_starts_with($href, 'https://')) {
            return $href;
        }

        try {
            return $node->link()->getUri();
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Fetch and pull OpenGraph meta tags.
     */
    protected function extractOpenGraph(string $url): array
    {
        $html = $this->fetch($url);
        $crawler = new Crawler($html, $url);

        $get = function (string $property) use ($crawler): ?string {
            $node = $crawler->filter('meta[property="' . $property . '"]');

            if ($node->count() === 0) {
                $node = $crawler->filter('meta[name="' . $property . '"]');
            }

            return $node->count()
                ? trim($node->first()->attr('content'))
                : null;
        };

        // Reject non-article pages
        $type = strtolower($get('og:type') ?? '');

        if (!in_array($type, $this->allowedOgTypes, true)) {
            return [];
        }

        $title = $get('og:title') ?? $this->firstOrNull($crawler, 'title');
        $description = $get('og:description') ?? $get('description');
        $image = $get('og:image');
        $category = $this->categoryFromKeywords($get('keywords')) 
                    ?? $get('article:section') 
                    ?? $get('og:section') 
                    ?? $this->categoryFromUrl($url);

        return [
            'title' => $title ?: null,
            'description' => $description ?: null,
            'image' => $image ?: null,
            'category' => $category ? strtolower($category) : null,
        ];
    }

    /**
     * scrap category from url
     */
    protected function categoryFromUrl(string $url): ?string
    {
        $path = trim(parse_url($url, PHP_URL_PATH) ?? '', '/');
        if ($path === '') {
            return null;
        }

        $segments = explode('/', $path);

        if (
            count($segments) >= 4
            && preg_match('/^\d{4}$/', $segments[0])
            && preg_match('/^\d{1,2}$/', $segments[1])
            && preg_match('/^\d{1,2}$/', $segments[2])
        ) {
            return $segments[3];
        }

        if (count($segments) >= 2 && !preg_match('/^\d+$/', $segments[0])) {
            return $segments[0];
        }

        return null;
    }
   /**
     * scrap category from meta keywords
     */
protected function categoryFromKeywords(?string $raw): ?string
{
    if (!$raw) {
        return null;
    }
 
    $keywords = array_values(array_filter(array_map('trim', explode(',', $raw))));
    $keywords = array_slice($keywords, 0, 2);
 
    return $keywords ? strtolower(implode(', ', $keywords)) : null;
}
    protected function firstOrNull(Crawler $crawler, string $selector): ?string
    {
        $node = $crawler->filter($selector);
        return $node->count() > 0 ? $node->first()->text() : null;
    }
}