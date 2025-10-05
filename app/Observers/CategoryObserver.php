<?php

namespace App\Observers;

use App\Models\Category;
use App\Services\ClearCacheService;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        // clear categories caches
        app(ClearCacheService::class)->clearCategoriesCaches($category);
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        // clear categories caches
        app(ClearCacheService::class)->clearCategoriesCaches($category);
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        // clear categories caches
        app(ClearCacheService::class)->clearCategoriesCaches($category);
    }

  
}
