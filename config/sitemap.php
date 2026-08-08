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

    'rss' => [
          'title' => env('APP_NAME', 'Myblog4u Social Network').' sitemap',
          'description' => 'Myblog4u a social network that connect creators, writes, publishers',
          'link' => env('APP_URL', 'https://myblog4u.site/blog'),
          'image' => 'https://myblog4u.site/blog/img/logo2.png',
         ]
];
