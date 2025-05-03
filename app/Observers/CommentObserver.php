<?php

namespace App\Observers;

use App\Models\Comment;
use App\Models\User;
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
            return;
      }

        $commenter = $comment->user; 
        $post = $comment->post;
         // Notify the post owner 
         if ($post->user_id !== $commenter->id) {
          $post->user->notify(new CommentNotification($comment, $commenter,$post));
      }

    // Notify  admins
    User::where('is_admin', true)->get()->each(function ($admin) use ($comment, $commenter, $post) {
    $admin->notify(new CommentNotification($comment, $commenter, $post));
     });
    
    }
   
    public function deleting(Comment $comment){
      // auto delete comment notification if commenter deleted his comment
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
