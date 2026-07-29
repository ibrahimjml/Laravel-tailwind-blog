<?php
namespace App\Services;

use App\Models\Category;
use App\Models\Hashtag;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class ClearCacheService
{
  public function clearPostCaches(Post $post)
  {

    Cache::forget('active_hashtags');
    Cache::tags(["tag_posts_paginated","tag_posts_sliders"])->flush();

    Cache::tags(['category_posts_paginated','category_posts_sliders'])->flush();
    Cache::forget('categories');
    
    Cache::tags(["Not-following"])->flush();
    
    Cache::tags(["blog_posts_paginated"])->flush();

    Cache::tags(["post:{$post->id}:comments"])->flush();
        
    Cache::forget("post:{$post->id}:more_articles");
    Cache::forget("latest_blogs:except:{$post->id}");
    
    Cache::tags(["search:posts"])->flush();
    
  }
  public function clearTagsCaches(Hashtag $hashtag)
  {
    Cache::tags(["tag_posts_paginated","tag_posts_sliders"])->flush();
    Cache::forget('active_hashtags');
  }

  public function clearCategoriesCaches(Category $category)
  {
     Cache::tags(['category_posts_paginated','category_posts_sliders'])->flush();
     Cache::forget('categories');
  }

  public function clearScrapedDataNews()
  {
    collect(['latest-news','latest-sources'])->each(fn ($key) => Cache::forget($key));
    Cache::tags(['news_paginated'])->flush();
  }
}