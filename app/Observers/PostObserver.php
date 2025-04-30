<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
            $oldimage = 'uploads/' . $post->image_path;
            Log::info('Trying to delete old image: ' . $oldimage);
    
            if (Storage::disk('public')->exists($oldimage)) {
              Storage::disk('public')->delete($oldimage);
                Log::info('image deleted : '.$post->image_path);
            } else {
                Log::warning('old image not found: ');
            }
        }
        // delete images inside tinyMCE
        $html = $post->description;
        if (!empty($html)) {
          libxml_use_internal_errors(true);

        $dom = new \DOMDocument();
        $dom->loadHTML($html);
    
        $images = $dom->getElementsByTagName('img');
    
        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            Log::info('Found TinyMCE image src: ' . $src);

            $path = str_replace('/storage/', 'public/', parse_url($src, PHP_URL_PATH));
    
            if (Storage::exists($path)) {
                Storage::delete($path);
                Log::info('Found TinyMCE image src: ' . $src .'deleted');
            }
            Log::warning('Not Found TinyMCE image');
        }
    
        libxml_clear_errors();
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
