<?php

namespace App\Observers;

use App\Models\Comment;

class CommentObserver
{
    /**
     * Handle the Comment "created" event.
     */
    public function created(Comment $comment): void
    {
      if ($comment->parent_id) {
        Comment::where('id', $comment->parent_id)
            ->increment('replies_count');
    }
    }


    public function deleted(Comment $comment): void
    {
      if ($comment->parent_id) {
        Comment::where('id', $comment->parent_id)
            ->decrement('replies_count');
    }
    }

}
