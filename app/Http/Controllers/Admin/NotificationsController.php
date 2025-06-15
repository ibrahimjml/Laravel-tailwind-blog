<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\NotificationService;

class NotificationsController extends Controller
{
    public function notifications(NotificationService $service)
    {
    $sortoption = request()->get('sort');
    $filtertype = request()->get('type');

    $data = $service->sortNotifications($sortoption,$filtertype);
    return view('admin.admin-notifications', [
      'notifiedUsers'=>$data['notifiedUsers'],
      'notifications'=>$data['notifications']
    ]);
    }
}
