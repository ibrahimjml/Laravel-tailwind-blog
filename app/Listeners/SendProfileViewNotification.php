<?php

namespace App\Listeners;

use App\Events\ProfileViewedEvent;
use App\Models\User;
use App\Notifications\viewedProfileNotification;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Notifications\DatabaseNotification;
class SendProfileViewNotification
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
    public function handle(ProfileViewedEvent $event): void
    {
      $viewer = $event->viewer;
      $profileowner = $event->user;

    if ($viewer->is_admin || $viewer->id === $profileowner->id) return;

          $notifyIDs = User::where('is_admin',true)
                  ->pluck('id')
                  ->push($profileowner->id)
                  ->unique();
    
    foreach($notifyIDs as $notifyID){
      $allreadynotified = DatabaseNotification::where('notifiable_id',$notifyID)
      ->where('type',viewedProfileNotification::class)
      ->whereJsonContains('data->viewer_id',$viewer->id)
      ->whereJsonContains('data->profile_id',$profileowner->id)
      ->where('created_at','>=',Carbon::now()->subDay())
      ->exists();
    
      if(!$allreadynotified){
        $newnotify = User::find($notifyID);
        if($newnotify){
          $newnotify->notify(new viewedProfileNotification($profileowner,$viewer));
         }
       }
     }
    }
}
