<?php

namespace App\Events;

use App\Services\Sitemap\SitemapManager;
use Illuminate\Foundation\Events\Dispatchable;

class SitemapRendering
{
    use Dispatchable;

    public function __construct(
        public readonly SitemapManager $manager,
        public readonly string $group,
        public readonly string $format,
        public readonly string $extension,
    )
    {
    }
}
