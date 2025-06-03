<?php

namespace App\Policies;

use App\Models\User;


class Userpolicy
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
    public function view(User $user, User $model): bool
    {
      return  $user->id === $model->id ;
    }

  
    public function update(User $user, User $model): bool
    {
      return  $user->id === $model->id ;
    }
    public function role(User $user, User $model): bool
    {
        return $user->id !== $model->id ;
    }
   public function block(User $user, User $model): bool
    {
        return $user->id !== $model->id ;
    }
    public function delete(User $user, User $model): bool
    {
        return  $user->id === $model->id ;
    }
  

}
