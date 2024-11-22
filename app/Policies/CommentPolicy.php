<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;


class CommentPolicy
{
  
    public function delete(User $user, Comment $comment): bool
    {
      return $user->is_admin === 1 || $user->id === $comment->user_id;
    }

  
}
