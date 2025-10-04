<?php

namespace App\Services;

use App\Enums\ReportReason;
use App\Models\Comment;
use App\Models\Post;

class ViewPostService
{
    public function getPost( Post $post)
  {   
        if ($post->status !== \App\Enums\PostStatus::PUBLISHED){
            abort(404);
        }
         $post->load([
            'user.roles:id,name', 
            'viewers:id,name,username,avatar'
        ]);
        $post->morearticles = $this->getMoreArticles($post);
        $post->latestblogs = $this->getLatestBlogs($post);
        $post->reasons = $this->getReportReasons();
        $post->viewwholiked = $this->getPostLikes($post);
        
     return $post->loadCount('totalcomments');
                
  }
     public function getPaginatedComments(Post $post, int $page = 1, int $perPage = 1)
    {
       return Comment::withNestedReplies(3)
                        ->addSelect(['post_user_id' => Post::select('user_id')
                        ->whereColumn('id', 'comments.post_id')
                        ->limit(1)
                              ])
                      ->where('post_id', $post->id)
                      ->whereNull('parent_id') 
                      ->latest()
                      ->paginate($perPage, ['*'], 'page', $page);
    
    }
    public function getMoreArticles(Post $post)
    {
       return Post::query()
                  ->published()
                  ->with(['user:id,name,username,avatar'])
                   ->withCount(['comments as total_comments_count' => function($query) {
                         $query->whereNull('parent_id'); 
                      }])
                  ->where('user_id', $post->user_id)
                  ->where('id', '!=', $post->id)
                  ->take(3)
                  ->get();
    }
     public function getLatestBlogs(Post $post)
    {
        return Post::published()
                    ->latest()
                    ->with(['user:id,name,username,avatar'])
                    ->withCount(['comments as total_comments_count' => function($query) {
                       $query->whereNull('parent_id'); 
                    }])
                   ->where('id', '!=', $post->id)
                   ->take(8)
                   ->get();
    }
     public function getPostLikes(Post $post)
    {
         return $post->likes()
            ->with(['user' => function($query) {
                $query->select('id', 'name', 'username', 'avatar');
            }])
            ->get();
    
    }
    public function getReportReasons()
    {
        return collect(ReportReason::postReasons())->map(function($case) {
            return [
                'name' => $case->name,
                'value' => $case->value
            ];
        });
    }
}
