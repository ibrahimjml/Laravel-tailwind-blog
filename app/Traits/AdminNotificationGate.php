<?php

namespace App\Traits;

use App\Enums\NotificationType;
use App\Models\User;

trait AdminNotificationGate
{
     public static function allow(User $user, NotificationType $type)
     {
       if(! ($user->is_admin || $user->hasRole('Admin'))){
          return false;
       }
        return $user->adminNotificationSettings()
                    ->where('type', $type->value)
                    ->where('is_enabled', true)
                    ->exists();
     }
}
            