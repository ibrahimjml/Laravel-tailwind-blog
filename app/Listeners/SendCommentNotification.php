<?php

namespace App\Listeners;

use App\Events\CommentCreatedEvent;
use App\Models\User;
use App\Notifications\CommentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCommentNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CommentCreatedEvent $event): void
    {
          $comment = $event->comment;
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
}
