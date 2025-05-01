<?php

namespace App\Observers;

use App\Models\Comment;
use App\Notifications\CommentNotification;
use App\Notifications\RepliedCommentNotification;
use Illuminate\Notifications\DatabaseNotification;

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
   
    public function deleting(Comment $comment){
      // auto delete comment notification if replier deleted his comment
      DatabaseNotification::where('type', CommentNotification::class)
      ->whereJsonContains('data->comment_id', $comment->id)
      ->delete();
      
      // auto delete reply notification if replier deleted his reply
      DatabaseNotification::where('type', RepliedCommentNotification::class)
      ->whereJsonContains('data->reply_id', $comment->id)
      ->delete();
    }

    public function deleted(Comment $comment): void
    {
      if ($comment->parent_id) {
        Comment::where('id', $comment->parent_id)
            ->decrement('replies_count');
    }
    }

}
