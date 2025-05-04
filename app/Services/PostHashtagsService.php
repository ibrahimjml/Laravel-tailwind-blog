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
}