<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\User;

class MentionUsersService
{
  public function handleMention(Comment $comment)
  {
    if (!empty($comment->content)) {
      $pattern = '/@\[(\w[\w.-]+)\]/';
      preg_match_all($pattern, $comment->content, $matches, PREG_SET_ORDER);

      if (!empty($matches)) {
        $mentionedUsernames = collect($matches)->pluck(1)->all();

        $UserIds = User::whereIn('username', $mentionedUsernames)
          ->pluck('id')
          ->all();

        $comment->mentions()->sync($UserIds);
      }
    }
  }
}
