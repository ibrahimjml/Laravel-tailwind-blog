<?php

namespace App\Services\Admin;

use App\Models\User;

class NotificationService
{
  /**
     * Get notifications with sorting and filtering.
     *
     * @param string|null $sortoption
     * @param string|null $filtertype
     * @return array
     */
    public function sortNotifications(?string $sortoption,?string $filtertype)
    {
          $notifyquery = auth()->user()->notifications();

    switch ($sortoption) {
      case 'read':
        $notifyquery->whereNotNull('read_at');
        break;
      case 'unread':
        $notifyquery->whereNull('read_at');
        break;
      default:
      $notifyquery->latest();
        break;
    };
    if($filtertype){
      $notifyquery->where('data->type',$filtertype);
    }
  
    // collect user notification data by username
    $usernames = collect($notifyquery->get())
            ->pluck('data')
            ->flatMap(fn($data)=>collect($data)->filter(fn($val,$key)=> str_contains($key,'username')))
            ->unique()
            ->values();
    $notifiedUsers = User::whereIn('username',$usernames)->get()->keyBy('username');

    $notifications = $notifyquery->paginate(7)->withQuerystring();
    return [
      'notifiedUsers'=>$notifiedUsers,
      'notifications'=>$notifications
    ];
    }
}
