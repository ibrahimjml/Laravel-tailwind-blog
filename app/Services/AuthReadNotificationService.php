<?php

namespace App\Services;

class AuthReadNotificationService
{
    public function readNotications(string $id)
    {
      $notifications = auth()->user()->notifications()->findOrFail($id);
      $notifications->markAsRead();

      $data = $notifications->data;
      $type = $data['type'] ?? null;
      $username = null;

      foreach ($data as $key => $value) {
          if (!$username && str_contains($key, 'username')) {
              $username = $value;
              break;
          }
      }
      if(in_array($type, ['like', 'Postcreated', 'comments', 'reply','postreport'])){
        return to_route('single.post',$data['post_link']);
        
      }elseif(in_array($type, ['follow','viewedprofile','newuser'])){
        return to_route('profile',$username);
      }
    }
}
