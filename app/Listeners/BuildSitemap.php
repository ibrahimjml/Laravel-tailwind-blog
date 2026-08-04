<?php

namespace App\Listeners;

use App\Events\SitemapRendering;

class BuildSitemap
{
    public function handle(SitemapRendering $event): void
    {
        if ($event->manager->isCached()) {
            return;
        }

        if ($event->format === 'sitemapindex') {
            foreach ($event->manager->groups() as $group) {
                $event->manager->addSitemap(route('public.sitemap.index', [
                    'key' => $group,
                    'extension' => $event->extension,
                ]));
            }

            return;
        }

        $event->manager->build($event->group);
    }
}
