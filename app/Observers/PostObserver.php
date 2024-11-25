<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Str;
class PostObserver
{
    
    public function creating(Post $post)
    {
            $slug = Str::slug($post->title);
            $post->slug = $this->generateUniqueSlug($slug);
    }

    public function updating(Post $post)
    {
      if($post->isDirty('title')){
        $slug = Str::slug($post->title);
        $post->slug = $this->generateUniqueSlug($slug);
      }
    }

    public function deleting(Post $post){
      if (!empty($post->image_path)) {
        $image = public_path('images/' . $post->image_path);

        if (file_exists($image)) {
            unlink($image);  
    }
    }
  }
    private function generateUniqueSlug($slug)
    {
        $originalSlug = $slug;
        $count = 1;

        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
