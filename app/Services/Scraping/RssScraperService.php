<?php

namespace App\Services\Scraping;

use App\Actions\CreateScraperLogAction;
use App\Actions\DeleteOldCrawlAction;
use App\Contracts\ScraperInterface;
use App\Models\Scraping\ScrapedPost;
use App\Models\Scraping\ScrapingSource;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class RssScraperService implements ScraperInterface
{
    public function __construct(
        protected Client $client,
        protected CreateScraperLogAction $log,
        protected DeleteOldCrawlAction $deleteOldCrawls,
    ) {
    }

    public function scrape(ScrapingSource $source): void
    {
        $this->log->create($source, 'info', "Starting feed crawl for {$source->name} ({$source->url})");

        try {
            $deleted = $this->deleteOldCrawls->delete($source);
            if($deleted > 0){
            $this->log->create($source, 'info', "Deleted {$deleted} crawl(s) older than {$source->max_age_hours}h.");
            }
        } catch (\Throwable $e) {
            $this->log->create($source, 'error', "Error Deleting old articles");
        }

        try {
            $xml = (string) $this->client->get($source->url)->getBody();
        } catch (GuzzleException $e) {
            $this->log->create($source, 'error', "Failed to fetch feed URL: {$e->getMessage()}");
            return;
        }

        $doc = @simplexml_load_string($xml);
        if (!$doc) {
            $this->log->create($source, 'error', 'Feed URL did not return parseable XML.');
            return;
        }

        $rootName = $doc->getName();

        $items = match (true) {
            $rootName === 'rss' => $this->parseRss($doc),
            $rootName === 'urlset' => $this->parseNewsSitemap($doc, $source),
            default => [],
        };

        $items = array_slice($items, 0, $source->max_links);

        $this->log->create($source, 'info', "Detected feed format: <{$rootName}> — found " . count($items) . ' item(s).');

        if (empty($items)) {
            $source->update(['last_run_at' => now()]);
            return;
        }

        $saved = 0;
        $skipped = 0;

        foreach ($items as $item) {
            $linkHash = md5($item['link']);

            if (ScrapedPost::where('link_hash', $linkHash)->exists()) {
                continue;
            }


            if ($source->skip_no_image && empty($item['image'])) {
                $skipped++;
                continue;
            }

            if ($source->skip_no_category && empty($item['category'])) {
                $skipped++;
                continue;
            }

            ScrapedPost::create([
                'scraping_source_id' => $source->id,
                'link_hash' => $linkHash,
                'link' => $item['link'],
                'title' => $item['title'],
                'description' => $item['description'],
                'category' => $item['category'],
                'image_url' => $item['image'],
                'last_scraped_at' => now(),
            ]);

            $saved++;
        }

        $this->log->create($source,'success',"Feed crawl finished. Saved {$saved},  skipped {$skipped}.");

        $source->update(['last_run_at' => now()]);
    }

    /**
     * Standard RSS 2.0: <rss><channel><item>...</item></channel></rss>
     */
    protected function parseRss(\SimpleXMLElement $doc): array
    {
        $items = [];
        $namespaces = $doc->getNamespaces(true);
        $media = $namespaces['media'] ?? null;

        foreach ($doc->channel->item as $node) {
            $image = null;

            if (isset($node->enclosure) && str_starts_with((string) $node->enclosure['type'], 'image/')) {
                $image = (string) $node->enclosure['url'];
            }

            if (!$image && $media) {
                $mediaContent = $node->children($media);
                if (isset($mediaContent->content)) {
                    $image = (string) $mediaContent->content->attributes()->url;
                } elseif (isset($mediaContent->thumbnail)) {
                    $image = (string) $mediaContent->thumbnail->attributes()->url;
                }
            }

            $items[] = [
                'link' => trim((string) $node->link),
                'title' => trim((string) $node->title) ?: null,
                'description' => trim((string) ($node->description ?? '')) ?: null,
                'category' =>  $this->categoryFromUrl($node->link) ?? null,
                'image' => $image,
                'published_at' => isset($node->pubDate) ? (string) $node->pubDate : null,
            ];
        }

        return $items;
    }

    protected function parseNewsSitemap(\SimpleXMLElement $doc, ScrapingSource $source): array
    {
        $items = [];
        $namespaces = $doc->getNamespaces(true);

        foreach ($doc->url as $node) {
            $link = trim((string) $node->loc);
            if (!$link) {
                continue;
            }

            $title = null;
            $publishedAt = (string) ($node->lastmod ?? '');

            if (isset($namespaces['news'])) {
                $news = $node->children($namespaces['news']);
                if (isset($news->news->title)) {
                    $title = trim((string) $news->news->title);
                }
                if (isset($news->news->publication_date) && (string) $news->news->publication_date) {
                    $publishedAt = (string) $news->news->publication_date;
                }
            }

            $image = null;
            if (isset($namespaces['image'])) {
                $imageNs = $node->children($namespaces['image']);
                if (isset($imageNs->image->loc)) {
                    $image = trim((string) $imageNs->image->loc);
                }
            }

            $items[] = [
                'link' => $link,
                'title' => $title,
                'description' => null,
                'category' => $this->categoryFromUrl($link),
                'image' => $image,
                'published_at' => $publishedAt ?: null,
            ];
        }

        return $items;
    }
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
}