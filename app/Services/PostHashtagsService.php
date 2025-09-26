<?php
namespace App\Services;

use App\Models\Hashtag;
use App\Models\Post;

class PostHashtagsService
{
  public function attachhashtags(Post $post, string $hashtag)
  {
    $tags = explode(',', $hashtag);

        foreach ($tags as $tag) {
            $tag = strip_tags(trim($tag));

            if ($tag) {
                $hashtag = Hashtag::firstOrCreate(['name' => $tag]);

                if($hashtag->status === \App\Enums\TagStatus::ACTIVE){
                  $post->hashtags()->attach($hashtag->id);
                }
            }
        }
  }
  public function syncHashtags(Post $post, ?string $hashtag)
  {
      if (!empty($hashtag)) {
      $hashtags = array_unique(array_filter(array_map('trim', explode(',', $hashtag))));
      $hashtagIds = [];

      foreach ($hashtags as $name) {
          $hashtag = Hashtag::firstOrCreate(['name' => strip_tags(trim($name))]);
          
          if($hashtag->status === \App\Enums\TagStatus::ACTIVE){
            $hashtagIds[] = $hashtag->id;
          }
      }
      $post->hashtags()->sync($hashtagIds);
    } else {
      $post->hashtags()->detach();
    }
  }
}