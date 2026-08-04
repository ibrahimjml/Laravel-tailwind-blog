<?php

namespace App\Http\Controllers;

use App\Events\SitemapRendering;
use App\Services\Sitemap\SitemapManager;
use Illuminate\Http\Response;

class SitemapController extends Controller
{

    public function __invoke(SitemapManager $manager, string $key, string $extension): Response
    {
        // refer to sitemap.xml or sitemap.rss
        $format = $key === 'sitemap' && in_array($extension, ['xml', 'rss'], true)
            ? 'sitemapindex'
            : $extension;

        return $this->renderSitemap($manager, $key, $format, $extension);
    }

    private function renderSitemap(SitemapManager $manager, string $group, string $format, ?string $extension = null): Response
    {
        $manager->init($group . '.' . ($extension ?? $format));
        SitemapRendering::dispatch($manager, $group, $format, $extension ?? $format);

        return $manager->render($format);
    }
}
