<?php

namespace App\Policies;

use App\Models\User;


class Userpolicy
{
  
    public function view(User $user, User $model): bool
    {
      return $user->is_admin || $user->id === $model->id;
    }

  
    public function update(User $user, User $model): bool
    {
      return $user->is_admin  || $user->id === $model->id;
    }

  
    public function delete(User $user, User $model): bool
    {
      return $user->is_admin  || $user->id === $model->id;
    }

    public function modify(User $user, User $model): bool
    {
      return $user->is_admin === 1 && $user->id !== $model->id; 
    }
    

}
