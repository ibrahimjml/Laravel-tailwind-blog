<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;


class PostPolicy
{
  
    public function view(User $user, Post $post): bool
    {
      return $user->is_admin === 1 || $user->id === $post->user_id;
    }
  
    public function update(User $user, Post $post): bool
    {
      return $user->is_admin === 1 || $user->id === $post->user_id;
    }

  
    public function delete(User $user, Post $post): bool
    {
      return $user->is_admin === 1 || $user->id === $post->user_id;
    }

}
