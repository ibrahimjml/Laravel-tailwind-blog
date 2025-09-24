<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;


class CommentPolicy
{
   public function before(User $user, string $ability): bool|null
    {
        if ( $user->hasRole('Admin')) {
            return true; 
        }
        $permission = "comment.$ability";
        if ($user->hasPermission($permission)) {
        return true;
    }
        return null; 
    }
    public function edit(User $user, Comment $comment): bool
    {
      return  $user->id === $comment->user_id;
    }

    public function delete(User $user, Comment $comment): bool
    {
      return  $user->id === $comment->user_id;
    }
    
    public function report(User $user, Comment $comment): bool
    {
      if($comment->user_id === $user->id) return false;
      if($comment->user && $comment->user->hasRole('Admin')) return false;
       return true;
    }
  
}
