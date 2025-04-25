<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markasread($id){

      $notifications = auth()->user()->notifications()->findOrFail($id);
      $notifications->markAsRead();
      if($notifications->data['type'] == 'like'){
        return to_route('single.post',$notifications->data['post_link']);
      }elseif($notifications->data['type'] == 'follow'){
        return to_route('profile',$notifications->data['follower_username']);
      }
    
    }

    public function delete($id){
      $notification = auth()->user()->notifications()->findOrFail($id);
      $notification->delete();
      toastr()->success('deleted successfully',['timeOut'=>1000]);
      return back();
    }

    public function deleteAll(){
      auth()->user()->notifications()->delete();
      return back();
    }
}
