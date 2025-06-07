<?php

namespace App\Listeners;

use App\Events\FollowUserEvent;
use App\Models\User;
use App\Notifications\FollowersNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendFollowNotification
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
    public function handle(FollowUserEvent $event): void
    {
      $follower = $event->follower;
      $user = $event->user;
         $user->notify(new FollowersNotification($user,$follower));
  // Notify  admins
  User::where('is_admin', true)->get()->each(function ($admin) use ($user, $follower) {
    $admin->notify(new FollowersNotification($user, $follower));
     });
    }
}
