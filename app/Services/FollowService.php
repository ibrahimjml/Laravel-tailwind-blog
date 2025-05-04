<?php
namespace App\Services;

use App\Models\User;
use App\Notifications\FollowersNotification;
use Illuminate\Notifications\DatabaseNotification;

class FollowService
{
  public function toggle(User $follower,User $user)
  {
    if ($follower->isFollowing($user)) {
      $follower->followings()->detach($user->id);

    // Auto delete follow notification for admin and user
    $notifiableIds = User::where('is_admin', true)
    ->pluck('id')
    ->push($user->id)
    ->unique();
 
      DatabaseNotification::where('type',FollowersNotification::class)
      ->whereIn('notifiable_id', $notifiableIds)
      ->whereJsonContains('data->follower_id', $follower->id)
      ->delete();
  
      return false;
  } else {
      $follower->followings()->attach($user->id);
  
     $user->notify(new FollowersNotification($user,$follower));
  // Notify  admins
  User::where('is_admin', true)->get()->each(function ($admin) use ($user, $follower) {
    $admin->notify(new FollowersNotification($user, $follower));
     });
      return true;
  }
}
}