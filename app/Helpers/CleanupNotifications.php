<?php
namespace App\Helpers;

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;

class CleanupNotifications
{
  public static function deleteRelatedNotifications(User $user)
{
    $keys = [
        'viewer_username',
        'replier_username',
        'user_username',
        'username',
        'postedby_username',
        'follower_username',
        'commenter_username',
    ];

    DatabaseNotification::where(function ($query) use ($user, $keys) {
        foreach ($keys as $key) {
            $query->orWhereJsonContains("data->{$key}", $user->username);
        }
    })->delete();
}
}