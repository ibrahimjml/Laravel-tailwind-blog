<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
  public function admin(){
  
    $user = DB::table('users')->count();
    $post = DB::table('posts')->count();
    $likes = DB::table('likes')->count();
    $hashtags = DB::table('hashtags')->count();
    $comments = DB::table('comments')->count();
    $blocked = DB::table('users')->where('is_blocked',1)->count();
    return view('admin.adminpanel',compact(['user','post','likes','hashtags','comments','blocked']));
  }

  public function users(Request $request)
  {
    $blocked = $request->has('blocked') ? 1 : null;

    $users = User::select('id','name','username','email','avatar','created_at','phone','age','is_blocked','email_verified_at','is_admin')
    ->latest()
    ->search($request->only('search'))
    ->when($blocked,function($q){
      $q->where('is_blocked',1);
    })
    ->paginate(6)
    ->withQuerystring();
    return view('admin.users',['users'=>$users,'filter'=>$request->only(['search','blocked'])]);
  }

  public function posts(Request $request)
  {
    $sort = $request->get('sort', 'latest'); 
    $choose = $sort === 'oldest' ? 'ASC' : 'DESC';

    $posts = Post::with(['user','hashtags'])
          ->search($request->only('search'))
          ->withCount(['likes', 'comments'])
          ->orderBy('created_at', $choose)
          ->paginate(6)
          ->withQuerystring();

    return view('admin.posts',['posts'=>$posts,'filter'=>$request->only('search','sort')]);
  }
  public function destroy(User $user){
  
    
    $this->authorize('deleteuser',$user);
    $user->delete();
    return back()->with('success',"user deleted");
  }
  public function block(User $user){
    $this->authorize('block',$user);
    $user->is_blocked = true;
    $user->save();
    return back()->with('success',"user blocked");
  }
  public function unblock(User $user){
    $this->authorize('block',$user);
    $user->is_blocked = false;
    $user->save();
    return back()->with('success',"user unblocked successfuly");
  }
}
