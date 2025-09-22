<?php

namespace App\Services;

use App\Enums\NotificationType;

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
      if(in_array($type, NotificationType::postRelated())){
        return to_route('single.post',$data['post_link']);
        }
      if(in_array($type, NotificationType::userRelated())){
        return to_route('profile',$username);
      }
    }
}
