<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;


class CommentPolicy
{
   public function before(User $user, string $ability,?Comment $model): bool|null
    {
        if ( $user->hasRole(\App\Enums\UserRole::ADMIN->value)) {
            return true; 
        }

        if($model instanceof Comment && $model->user->hasRole(\App\Enums\UserRole::ADMIN->value)) {
           return false;
         }

        return null; 
    }
    public function edit(User $user, Comment $comment): bool
    {
      return $user->hasPermission('comment.edit') || $user->id === $comment->user_id;
    }

    public function delete(User $user, Comment $comment): bool
    {
      return $user->hasPermission('comment.delete') || $user->id === $comment->user_id;
    }
    
    public function report(User $user, Comment $comment): bool
    {
       return $user->id !== $comment->user_id;
    }
  
}
