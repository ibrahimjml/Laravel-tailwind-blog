<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckIfBlocked;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth','verified',CheckIfBlocked::class]);
  }
  
    public function markasread($id){

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
