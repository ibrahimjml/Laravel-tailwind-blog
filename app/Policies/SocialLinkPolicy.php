<?php

namespace App\Policies;

use App\Models\SocialLink;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SocialLinkPolicy
{
   public function before(User $user, string $ability): bool|null
    {
        if ( $user->hasRole('Admin')) {
            return true; 
        }
       $permission = "user.$ability";
    
    if ( $user->hasPermission($permission)) {
        return true;
    }
        return null; 
    }

    public function deleteSocial(User $user,SocialLink $link)
    {
      return $user->id === $link->user_id;
    }
}
