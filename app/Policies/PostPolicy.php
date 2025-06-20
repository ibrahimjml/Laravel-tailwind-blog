<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;


class PostPolicy
{
  public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('Admin') ) {
            return true; 
        }
        $permission = "post.$ability";
        if ($user->hasPermission($permission)) {
        return true;
    }
        return null; 
    }
    public function view(User $user, Post $post): bool
    {
      return  $user->id === $post->user_id;
    }
  
    public function update(User $user, Post $post): bool
    {
      return  $user->id === $post->user_id;
    }
  public function make_feature(User $user, Post $post): bool
    {
      return  $user->hasPermission('post.feature');
    }
  public function report(User $user, Post $post): bool
  {
    if($post->user_id === $user->id) return false;
    if($post->user && $post->user->hasRole('Admin')) return false;
    return true;
  }
    public function delete(User $user, Post $post): bool
    {
      return  $user->id === $post->user_id;
    }

}
