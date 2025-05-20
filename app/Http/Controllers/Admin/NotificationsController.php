<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function notifications()
    {
  $sortoption = request()->get('sort');
    $filtertype = request()->get('type');

    $notifications = auth()->user()->notifications();

    switch ($sortoption) {
      case 'read':
        $notifications->whereNotNull('read_at');
        break;
      case 'unread':
        $notifications->whereNull('read_at');
        break;
      default:
      $notifications->latest();
        break;
    };
    if($filtertype){
      $notifications->where('data->type',$filtertype);
    }
  
    // collect user notification data by username
    $usernames = collect($notifications->get())
            ->pluck('data')
            ->flatMap(fn($data)=>collect($data)->filter(fn($val,$key)=> str_contains($key,'username')))
            ->unique()
            ->values();
    $notifiedUsers = User::whereIn('username',$usernames)->get()->keyBy('username');

    $notifications = $notifications->paginate(7)->withQuerystring();
    return view('admin.admin-notifications', compact('notifiedUsers','notifications'));
    }
}
