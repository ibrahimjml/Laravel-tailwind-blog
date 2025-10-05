<?php

namespace App\Providers;

use App\Models\{Category, Comment, Hashtag, Like, Permission, Post, PostReport, Role, User};
use App\Observers\{CommentObserver, LikeObserver, PostObserver, PostReportObserver, TagObserver, CategoryObserver, PermissionObserver, RoleObserver, UserObserver};
use App\Repositories\Caches\CategoryCacheDecorator;
use App\Repositories\Eloquent\PostRepository;
use App\Repositories\Caches\PostCacheDecorator;
use App\Repositories\Caches\TagCacheDecorator;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\TagRepository;
use App\Repositories\Interfaces\CategoryInterface;
use App\Repositories\Interfaces\PostInterface;
use App\Repositories\Interfaces\TagInterface;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PostInterface::class, function ($app) {
        if (config('cache.enabled')) {
            return new PostCacheDecorator($app->make(PostRepository::class));
        }
        return $app->make(PostRepository::class);
           });

        $this->app->bind(TagInterface::class, function ($app) {
        if (config('cache.enabled')) {
            return new TagCacheDecorator($app->make(TagRepository::class));
        }
        return $app->make(TagRepository::class);
           });

        $this->app->bind(CategoryInterface::class, function ($app) {
        if (config('cache.enabled')) {
            return new CategoryCacheDecorator($app->make(CategoryRepository::class));
        }
        return $app->make(CategoryRepository::class);
           });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
      Post::observe(PostObserver::class);
      Comment::observe(CommentObserver::class);
      Like::observe(LikeObserver::class);
      PostReport::observe(PostReportObserver::class);
      User::observe(UserObserver::class);
      Hashtag::observe(TagObserver::class);
      Category::observe(CategoryObserver::class);
      Permission::observe(PermissionObserver::class);
      Role::observe(RoleObserver::class);
      
      Blade::component('partials.postcard', 'postcard');
    }
}
