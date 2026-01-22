<?php

namespace App\Observers;

use App\Events\CommentCreatedEvent;
use App\Events\MentionedUserEvent;
use App\Models\Comment;
use App\Models\User;
use App\Notifications\CommentNotification;
use App\Notifications\RepliedCommentNotification;
use App\Notifications\SendMentionedUsersNotification;
use App\Services\ClearCacheService;
use App\Services\MentionUsersService;
use Illuminate\Notifications\DatabaseNotification;

class CommentObserver
{
  public function created(Comment $comment): void
  {
    if ($comment->parent_id) {
      Comment::where('id', $comment->parent_id)
        ->increment('replies_count');
      return;
    }
    // handle mention
    app(MentionUsersService::class)->handleMention($comment);
    // dont fire event if running in seeder
    if (!app()->runningInConsole()) {
      event(new CommentCreatedEvent($comment));
      event(new MentionedUserEvent($comment));
    }
    // clear all post cache and comment   
    app(ClearCacheService::class)->clearPostCaches($comment->post);
  }
  public function updated(Comment $comment)
  {
    // handle mention
    app(MentionUsersService::class)->handleMention($comment);
    // clear all post cache and comment   
    app(ClearCacheService::class)->clearPostCaches($comment->post);
  }
  public function deleting(Comment $comment)
  {
    // auto delete comment when get deleted
    DatabaseNotification::where('type', CommentNotification::class)
      ->whereJsonContains('data->comment_id', $comment->id)
      ->delete();

    // auto delete reply notification if replier deleted his reply
    DatabaseNotification::where('type', RepliedCommentNotification::class)
      ->whereJsonContains('data->reply_id', $comment->id)
      ->orWhereJsonContains('data->comment_id', $comment->id)
      ->delete();

      if($comment->mentions()->exists()){
        $comment->mentions()->detach();
        DatabaseNotification::where('type', SendMentionedUsersNotification::class)
        ->whereJsonContains('data->comment_id', $comment->id)
        ->delete();
      }
  }

  public function deleted(Comment $comment): void
  {
    if ($comment->parent_id) {
      Comment::where('id', $comment->parent_id)
        ->decrement('replies_count');
    }
    // clear all post cache and comment   
    app(ClearCacheService::class)->clearPostCaches($comment->post);
  }
}
