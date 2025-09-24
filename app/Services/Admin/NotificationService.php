<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;

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
       $adminIds = User::where('is_admin', true)->pluck('id');
    // fetch all notifications for admin 
    $notifyquery = DatabaseNotification::query()
        ->where('notifiable_type', User::class)
        ->whereIn('notifiable_id', $adminIds);
    // unread count
     $unreadCount = (clone $notifyquery)->whereNull('read_at')->count();

    switch ($sortoption) {
        case 'read':   $notifyquery->whereNotNull('read_at'); break;
        case 'unread': $notifyquery->whereNull('read_at'); break;
        default:       $notifyquery->latest(); break;
    }

    if ($filtertype) {
        $notifyquery->where('data->type', $filtertype);
    }


    $usernames = (clone $notifyquery)
              ->get()
              ->pluck('data')
              ->flatMap(fn($data) => collect($data)->filter(
                      fn($val, $key) => str_contains($key, 'username')
                  ))
              ->unique()
              ->values();

    $notifiedUsers = User::whereIn('username', $usernames)->get()->keyBy('username');

  
    $notifications = $notifyquery->paginate(7)->withQueryString();

    return [
        'notifiedUsers' => $notifiedUsers,
        'notifications' => $notifications,
        'unreadCount' => $unreadCount,
    ];
    }
}
