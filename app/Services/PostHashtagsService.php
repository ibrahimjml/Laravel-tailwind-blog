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
                $hashtagModel = Hashtag::firstOrCreate(['name' => $tag]);
                $post->hashtags()->attach($hashtagModel->id);
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
          $hashtagIds[] = $hashtag->id;
      }
      $post->hashtags()->sync($hashtagIds);
    } else {
      $post->hashtags()->detach();
    }
  }
}