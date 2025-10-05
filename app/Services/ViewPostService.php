<?php

namespace App\Services;

use App\Enums\ReportReason;
use App\Models\Post;

use App\Repositories\Interfaces\PostInterface;

class ViewPostService
{   public function __construct(private PostInterface $repo){}
    public function getPost( Post $post)
  {   
        if ($post->status !== \App\Enums\PostStatus::PUBLISHED){
            abort(404);
        }
    
        $post->load(['user.roles:id,name', 'viewers:id,name,username,avatar']);
        $page = (int) request('page', 1);
        $perpage = (int) request('perpage', 5);

        $post->morearticles = $this->repo->getRelatedArticles($post);
        $post->latestblogs = $this->repo->getLatestBlogs($post);
        $post->viewwholiked = $this->repo->getPostLikes($post);
        $post->comments = $this->repo->getPaginatedComments($post,$page,$perpage);
        $post->reasons = $this->getReportReasons();

        return $post->loadCount('totalcomments');
  
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
