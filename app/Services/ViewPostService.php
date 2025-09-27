<?php

namespace App\Services;

use App\Enums\ReportReason;
use App\Models\Post;

class ViewPostService
{
    public function getPost(Post $post)
    {   
        if ($post->status !== \App\Enums\PostStatus::PUBLISHED){
            abort(404);
        }
        $post->load(['user','user.roles','hashtags','comments','comments.user.roles','comments.replies.user.roles','viewers:id,name,username,avatar']);

 $post->morearticles = Post::query()
          ->published()
          ->with(['user:id,name,username,avatar'])
          ->where('user_id',$post->user_id)
          ->where('id','!=',$post->id)
          ->take(3)
          ->get();
 $post->latestblogs = Post::published()
          ->latest()
          ->with(['user:id,name,username,avatar'])
          ->where('id','!=',$post->id)
          ->get()
          ->take(8);          
 $post->reasons = collect(ReportReason::postReasons())->map(function($case){
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
