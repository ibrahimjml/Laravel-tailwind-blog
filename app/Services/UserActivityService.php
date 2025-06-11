<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;

class UserActivityService
{
    public function getUserActivities(User $user)
    {
        $posts = $user->post()
                ->select('title','created_at')->get()
                ->map(function($post){
                    return [
                        'type' => 'Posted',
                        'title' => $post->title,
                        'date' => $post->created_at,
                    ];
                });
            

        $comments = $user->comments()
                 ->select('content','created_at','parent_id')->get()
                 ->map(function($comment){
                     return [
                         'type' => $comment->parent_id ? 'Replied' : 'Commented',
                         'title' => $comment->content,
                         'date' => $comment->created_at,
                     ];
                 });
       
    return $posts->merge($comments)->sortByDesc('date')
            ->groupBy(fn($activity) => Carbon::parse($activity['date'])->format('M j Y'));
    }
}
