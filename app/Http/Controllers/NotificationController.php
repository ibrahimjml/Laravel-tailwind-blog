<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markasread($id){

      $notifications = auth()->user()->notifications()->findOrFail($id);
      $notifications->markAsRead();

      if($notifications->data['type'] == 'like' || $notifications->data['type'] == 'Postcreated' ||
       $notifications->data['type'] == 'comments' || $notifications->data['type'] == 'reply'){

        return to_route('single.post',$notifications->data['post_link']);
      }elseif($notifications->data['type'] == 'follow'){
        return to_route('profile',$notifications->data['follower_username']);
      }elseif($notifications->data['type'] == 'viewedprofile'){
        return to_route('profile',$notifications->data['viewer_username']);
      }
  }
    public function delete($id){
      $notification = auth()->user()->notifications()->findOrFail($id);
      $notification->delete();
      toastr()->success('Notification deleted successfully',['timeOut'=>1000]);
      return back();
    }

    public function deleteAll(){
      auth()->user()->notifications()->delete();
      toastr()->success('All notifications deleted successfully',['timeOut'=>1000]);
      return back();
    }
}
