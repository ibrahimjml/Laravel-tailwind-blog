<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
  public function admin(){
    $posts = Post::all();
    $users = User::all();
    return view('admin.adminpanel',['posts'=>$posts,'users'=>$users]);
  }

  public function destroy(User $user){
  
    
    Gate::authorize('makeAdminActions',$user);
    $user->delete();
    return back()->with('success',"user deleted");
  }
  public function block(User $user){
    Gate::authorize('makeAdminActions',$user);
    $user->is_blocked = true;
    $user->save();
    return back()->with('success',"user blocked");
  }
  public function unblock(User $user){
    Gate::authorize('makeAdminActions',$user);
    $user->is_blocked = false;
    $user->save();
    return back()->with('success',"user unblocked successfuly");
  }
}
