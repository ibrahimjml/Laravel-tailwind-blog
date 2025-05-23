<?php
namespace App\Services;

use App\Models\User;
use App\Notifications\viewedProfileNotification;
use Carbon\Carbon;
use Illuminate\Notifications\DatabaseNotification;

class ProfileViewNotify
{
  public function notifyview(User $viewer,User $profileowner)
  {
    if ($viewer->id === $profileowner->id ) return ;
  
    if($viewer->is_admin) return;

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