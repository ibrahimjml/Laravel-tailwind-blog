<?php

namespace App\Listeners;

use App\Events\PostLikedEvent;
use App\Models\User;
use App\Notifications\LikesNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendLikeNotification
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
    public function handle(PostLikedEvent $event): void
    {
        $like = $event->like;
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
}
