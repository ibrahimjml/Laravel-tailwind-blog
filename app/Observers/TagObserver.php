<?php

namespace App\Observers;

use App\Models\Hashtag;
use App\Services\ClearCacheService;
use Illuminate\Support\Facades\Cache;

class TagObserver
{
    /**
     * Handle the Hashtag "created" event.
     */
    public function created(Hashtag $hashtag): void
    {
        // clear tag caches
        app(ClearCacheService::class)->clearTagsCaches($hashtag);
    }

    /**
     * Handle the Hashtag "updated" event.
     */
    public function updated(Hashtag $hashtag): void
    {
          // clear tag caches
        app(ClearCacheService::class)->clearTagsCaches($hashtag);
    }

    /**
     * Handle the Hashtag "deleted" event.
     */
    public function deleted(Hashtag $hashtag): void
    {
          // clear tag caches
        app(ClearCacheService::class)->clearTagsCaches($hashtag);
    }

  
}
