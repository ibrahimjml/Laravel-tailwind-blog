<?php

namespace App\Services;

use App\Enums\ReportReason;
use App\Models\Post;

class ViewPostService
{
    public function getPost(Post $post)
    {
        $post->load(['user','user.roles','hashtags','comments','comments.user.roles','comments.replies.user.roles','viewers:id,name,username,avatar']);

 $post->morearticles = Post::query()
          ->with(['user:id,name,username,avatar'])
          ->where('user_id',$post->user_id)
          ->where('id','!=',$post->id)
          ->take(3)
          ->get();
 $post->reasons = collect(ReportReason::cases())->map(function($case){
    return [
      'name' => $case->name,
      'value' => $case->value
    ];
 });
 $post->viewwholiked = $post->likes()
       ->with('user:id,name,username,avatar')
       ->get();
 return $post;
    }
}
