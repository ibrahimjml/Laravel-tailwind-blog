<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Log;
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

    public function deleting(Post $post)
    {
        // Delete old image
        if (!empty($post->image_path)) {
            $oldimage = public_path('images/' . $post->image_path);
            Log::info('Trying to delete old image: ' . $oldimage);
    
            if (file_exists($oldimage)) {
                unlink($oldimage);
                Log::info('Featured image deleted.');
            } else {
                Log::warning('old image not found: ' . $oldimage);
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
