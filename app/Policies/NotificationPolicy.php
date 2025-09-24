<?php

namespace App\Policies;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NotificationPolicy
{
    

    public function view(User $user, Notification $notification): bool
    {
        return $user->hasPermission('notifications.view');
    }

    public function delete(User $user, Notification $notification): bool
    {
        return $user->hasPermission('notifications.delete');
    }

}
