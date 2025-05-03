<?php

namespace App\Observers;

use App\Models\Like;
use App\Models\User;
use App\Notifications\LikesNotification;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Mail;
use App\Mail\postlike;

class LikeObserver
{
    /**
     * Handle the Like "created" event.
     */
    public function created(Like $like): void
    {
      $like->load(['user','post']);
      $post = $like->post;
      $liker = $like->user;

      if($post->user->id !== auth()->user()->id){
        // Mail::to($post->user)->queue(new postlike($post->user, auth()->user(), $post));
        $post->user->notify(new LikesNotification($liker,$post));
      }
      // Notify  admins
      $liker = auth()->user();
      User::where('is_admin', true)->get()->each(function ($admin) use ($liker, $post) {
        $admin->notify(new LikesNotification($liker,$post));
         });
    }


public function deleted(Like $like): void
{

  $like->load(['user','post']);
  $post = $like->post;
  $liker = $like->user;
    // Auto delete like notification for admin and poster
    $notifiableIds = User::where('is_admin', true)
        ->pluck('id')
        ->push($post->user_id); 

    DatabaseNotification::where('type', LikesNotification::class)
        ->whereIn('notifiable_id', $notifiableIds)
        ->whereJsonContains('data->post_id', $post->id)
        ->whereJsonContains('data->user_id', $liker->id)
        ->delete();
}



}
