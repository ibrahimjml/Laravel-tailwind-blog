<?php
namespace App\Services;

use App\Models\User;
use App\Notifications\viewedProfileNotification;
use Carbon\Carbon;
use Illuminate\Notifications\DatabaseNotification;

class ProfileViewNotify
{
  public function notify(User $viewer,User $proileowner)
  {
    if ($viewer->id === $proileowner->id && $viewer->is_admin) {
      return;
    }
      $notifyIDs = User::where('is_admin',true)
                  ->pluck('id')
                  ->push($proileowner->id)
                  ->unique();
    
    foreach($notifyIDs as $notifyID){
      $allreadynotified = DatabaseNotification::whereIn('notifiable_id',$notifyID)
      ->where('type',viewedProfileNotification::class)
      ->whereJsonContains('data->viewer_id',$viewer->id)
      ->whereJsonContains('data->profile_id',$proileowner->id)
      ->where('created_at','>=',Carbon::now()->subDay())
      ->exists();
    
      if(!$allreadynotified){
        $newnotify = User::find($notifyID);
        if($newnotify){
          $newnotify->notify(new viewedProfileNotification($proileowner,$viewer));
         }
       }
     }
    
  }
}