<?php

namespace App\Services\User;

use App\Models\User;
use Carbon\Carbon;

class UserActivityService
{
    public function getUserActivities(User $user)
    {
        $posts = $user->post()
                ->select('title','created_at','slug')
                ->get()
                ->map(function($post){
                    return [
                        'type' => 'Posted',
                        'title' => $post->title,
                        'slug' => $post->slug,
                        'date' => $post->created_at,
                    ];
                });
            

        $comments = $user->comments()
                 ->with('post:id,slug,title')
                 ->select('id','created_at','parent_id','post_id')
                 ->get()
                 ->map(function($comment){
                     return [
                         'type' => $comment->parent_id ? 'Replied' : 'Commented',
                         'comment_id' => $comment->id,
                         'slug' => $comment->post->slug,
                         'post_title' =>$comment->post->title,
                         'date' => $comment->created_at,
                     ];
                 });
       
    return $posts->merge($comments)->sortByDesc('date')
            ->groupBy(fn($activity) => Carbon::parse($activity['date'])->format('M j Y'));
    }
}
