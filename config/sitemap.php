<?php

return [
    'cache' => [
        'enabled' => env('SITEMAP_CACHE', true),
        'key' => 'sitemap.',
        'ttl' => (int) env('SITEMAP_CACHE_TTL', 3600),
    ],

    'styles' => [
        'enabled' => env('SITEMAP_STYLES', true),
        'path' => public_path('sitemap-styles'),
        'url' => 'sitemap-styles',
    ],

    'default' => ['priority' => '0.8', 'changefreq' => 'daily'],
    'rss' => ['title' => env('APP_NAME', 'Blog').' sitemap'],
];
