<?php

namespace App\Services\Sitemap;

use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\View\Factory as ViewFactory;
use InvalidArgumentException;

class Sitemap
{
    private array $items = [];

    private array $sitemaps = [];

    private bool $useCache;

    private string $cacheKey;

    private int $cacheDuration;

    public function __construct(
        private readonly CacheRepository $cache,
        private readonly ConfigRepository $config,
        private readonly ViewFactory $view,
    ) {
        $this->useCache = (bool) $this->config->get('sitemap.cache.enabled', false);
        $this->cacheKey = (string) $this->config->get('sitemap.cache.key', 'sitemap.');
        $this->cacheDuration = (int) $this->config->get('sitemap.cache.ttl', 3600);
    }

    public function setCache(?string $key = null, ?int $duration = null, ?bool $useCache = null): void
    {
        $this->cacheKey = $key ?: $this->cacheKey;
        $this->cacheDuration = $duration ?? $this->cacheDuration;
        $this->useCache = $useCache ?? $this->useCache;
    }

    public function add(
          string $loc, 
          ?string $lastMod = null, 
          ?string $priority = null,
          ?string $freq = null, 
          array $images = [], 
          ?string $title = null, 
          ?string $short_excerpt = null,
          ?string $description = null,
          ?string $author = null): void
    {
        $this->items[] = [
            'loc' => URL::to($loc),
            'lastmod' => $lastMod,
            'priority' => $priority ?? $this->config->get('sitemap.default.priority'),
            'freq' => $freq ?? $this->config->get('sitemap.default.changefreq'),
            'images' => $images,
            'title' => $title,
            'short_excerpt' => $short_excerpt,
            'description' => $description,
            'author' => $author,
        ];
    }

    public function addItem(array $items): void
    {
        foreach (array_is_list($items) ? $items : [$items] as $item) {
            $this->add(
                $item['loc'] ?? '/', 
                $item['lastmod'] ?? null, 
                $item['priority'] ?? null,
                $item['freq'] ?? null, 
                $item['images'] ?? [], 
                $item['title'] ?? null, 
                $item['short_excerpt'] ?? null,
                $item['description'] ?? null,
                $item['author'] ?? null
            );
        }
    }

    public function addSitemap(string $loc, ?string $lastMod = null): void
    {
        $this->sitemaps[] = [
          'loc' => URL::to($loc), 
          'lastmod' => $lastMod
          ];
    }

    public function resetSitemaps(array $sitemaps = []): void
    {
        $this->sitemaps = $sitemaps;
    }

    public function resetItems(array $items = []): void
    {
        $this->items = $items;
    }

    public function isCached(): bool
    {
        return $this->useCache && $this->cache->has($this->cacheKey);
    }

    public function render(string $format = 'xml'): Response
    {
        $data = $this->generate($format);

        return response($data['content'], 200, $data['headers']);
    }

    public function generate(string $format = 'xml'): array
    {
        if (! in_array($format, ['xml', 'rss', 'txt', 'sitemapindex'], true)) {
            throw new InvalidArgumentException("Unsupported sitemap format [{$format}].");
        }

        if ($this->isCached()) {
            return $this->cache->get($this->cacheKey);
        }

        $style = $this->styleFor($format);

        $channel = [
            'title' => (string) $this->config->get('sitemap.rss.title', 'Sitemap for '.config('app.name')),
            'description' => (string) $this->config->get('sitemap.rss.description'),
            'image' =>  $this->config->get('sitemap.rss.image'),
            'link' =>  $this->config->get('sitemap.rss.link', config('app.url')),
        ];

        $data = match ($format) {
            'rss' => [
                'content' => $this->view->make(
                    'sitemap.rss',
                    ['items' => $this->items, 'channel' => $channel, 'style' => $style]
                )->render(),
                'headers' => ['Content-type' => 'application/xml; charset=utf-8'],
            ],
            'txt' => [
                'content' => $this->view->make(
                    'sitemap.txt',
                    ['items' => $this->items, 'style' => $style]
                )->render(),
                'headers' => ['Content-type' => 'text/plain; charset=utf-8'],
            ],
            'sitemapindex' => [
                'content' => $this->view->make(
                    'sitemap.sitemapindex',
                    ['sitemaps' => $this->sitemaps, 'style' => $style]
                )->render(),
                'headers' => ['Content-type' => 'application/xml; charset=utf-8'],
            ],
            default => [
                'content' => $this->view->make(
                    'sitemap.' . $format,
                    ['items' => $this->items, 'style' => $style]
                )->render(),
                'headers' => ['Content-type' => 'application/xml; charset=utf-8'],
            ],
        };

        if ($this->useCache) {
            $this->cache->put($this->cacheKey, $data, $this->cacheDuration);
        }

        return $data;
    }

    private function styleFor(string $format): ?string
    {
        if (! $this->config->get('sitemap.styles.enabled', false) || ! in_array($format, ['xml', 'rss', 'sitemapindex'], true)) {
            return null;
        }

        $file = match ($format) {
            'sitemapindex' => 'sitemapindex.xsl',
            default => 'xml.xsl',
        };
        $path = rtrim((string) $this->config->get('sitemap.styles.path'), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$file;

        return is_file($path) ? trim((string) $this->config->get('sitemap.styles.url', 'sitemap-styles'), '/').'/'.$file : null;
    }
}
