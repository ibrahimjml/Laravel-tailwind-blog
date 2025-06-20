<?php

namespace App\Traits;

use App\Models\Post;

trait SluggableTrait
{
    public function create(string $slug)
    {
       $originalSlug = $slug;
       $count = 1;

       do {
           $slug = $originalSlug . '-' . $count;
           $count++;
       } while (Post::where('slug', $slug)->exists());

       return $slug;
    }
}
