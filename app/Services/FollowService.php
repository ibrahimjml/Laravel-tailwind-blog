<?php
namespace App\Services;

use App\Enums\FollowerStatus;
use App\Events\FollowUserEvent;
use App\Models\User;
use App\Notifications\FollowersNotification;
use Illuminate\Notifications\DatabaseNotification;

class FollowService
{
 public function toggle(User $follower, User $user): ?int
    {
        $existing = $follower->followings()
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            $follower->followings()->detach($user->id);
            $this->deleteFollowNotification($follower, $user);
            return null;
        }

        $status = $user->profile->is_public 
        ? FollowerStatus::ACCEPTED
        : FollowerStatus::PENDING;

        $follower->followings()->attach($user->id, [
            'status' => $status->value,
        ]);

        event(new FollowUserEvent($follower,$user,$status->value === FollowerStatus::ACCEPTED ? 'public' : 'private'));

        return $status->value;
    }
protected function deleteFollowNotification($follower, $user){

    $notifiableIds = User::where('is_admin', true)
    ->pluck('id')
    ->push($user->id)
    ->unique();
 
      DatabaseNotification::where('type',FollowersNotification::class)
      ->whereIn('notifiable_id', $notifiableIds)
      ->whereJsonContains('data->follower_id', $follower->id)
      ->delete();
}
}