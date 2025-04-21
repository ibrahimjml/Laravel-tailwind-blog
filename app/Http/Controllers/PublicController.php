<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Http\Middleware\CheckIfBlocked;
use Illuminate\Support\Facades\Storage;


class PublicController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth','verified',CheckIfBlocked::class]);
  }


  public function search(Request $request)
  {
    $fields = $request->validate([
      'search' => 'required|string|max:255'
    ]);
    $postsid = Post::search($fields['search'])->get()->pluck('id');
     
    $posts = Post::whereIn('id',$postsid)
    ->withCount(['likes', 'comments'])
    ->with(['user','hashtags'])
    ->latest()
    ->paginate(5)
    ->withQuerystring();

    $meta_keywords = Post::with('hashtags')->latest()->first();

    return view('blog', [
      'posts' => $posts,
      'sorts' => 'latest',
      'searchquery'=>$fields['search'],
      'meta_title'=>'Blog-Post | Jamal',
      'meta_keywords' => $meta_keywords->hashtags->pluck('name')->take(6)->implode(', ')
    ]);
  }

  public function viewpost($slug)
  {
    $post = Post::with([
      'comments' => function ($query) {
          $query->latest()
              ->with(['user','replies'=>function($query){
                   $query->with(['replies']);
              } ,'replies.user', 'replies.parent.user']); 
      }
  ])->where('slug', $slug)->first();

 $morearticles = Post::query()
  ->with(['user'=> function ($query){
    $query->select('id','name','username','avatar');
  }])
 ->where('user_id',$post->user_id)
 ->where('id','!=',$post->id)
 ->take(3)
 ->get();

    return view('post', [
       'post' => $post,
       'morearticles' => $morearticles,
       'meta_title' => $post->slug . ' | Blog-Post',
       'author' => $post->user->username,
       'meta_description' => Str::limit(strip_tags($post->description), 150),
       'meta_keywords' => $post->hashtags->pluck('name')->implode(', ')
      ]);
  }

  public function viewprofile(User $user)
  {
    $postCount = $user->post()->count();
    $likeCount = $user->post()->withCount('likes')->get()->sum('likes_count');
    $commentCount = $user->post()->withCount('comments')->get()->sum('comments_count');
    $posts = Post::orderBy('created_at','DESC')->where('user_id', $user->id)->get();

    return view('profile', [
       'user' => $user, 
       'posts' => $posts,
       'postcount' => $postCount,
       'likescount' => $likeCount, 
       'commentscount' => $commentCount,
       'meta_title' => $user->username . ' | Profile',
       'author' => $user->username
      ]);
  }

  public function editpage(User $user)
  {
    $this->authorize('view', $user);
    return view('edit-avatar', compact('user'));
  }

  public function edit(Request $request, User $user)
  {
     $request->validate([
      'avatar' => 'required|image|mimes:png,jpeg,jpg|max:5048'
    ]);
    $avatarname= uniqid().'-'.$user->name.'.'.$request->file('avatar')->extension();
    $path = $request->file('avatar')->storeAs('images',$avatarname ,'public');

    $this->authorize('update', $user);
    $user->avatar = $path;
    $user->save();
    toastr()->success('Image updated successfully',['timeOut'=>1000]);
    return redirect()->route('profile',  $user->username);
    
  }
  public function destroyavatar(User $user){
    if($user->avatar && $user->avatar !== 'default.jpg'){
      Storage::delete('public/'.$user->avatar);
    }
    $this->authorize('delete',$user);
    $user->avatar="default.jpg";
    $user->save();
    toastr()->success('Avatar deleted',['timeOut'=>1000]);
    return redirect()->route('profile', $user->username);
  }

  public function editprofilepage(User $user)
  {

    $this->authorize('view',$user);
  
    return view('edit-profile',['user' => $user]);
  }


  public function editemail(Request $request, User $user)
  {
    $request->validate([
      "email" => ["required", "email", "min:5", "max:50", Rule::unique(User::class)->ignore($request->user()->id)]
    ]);

    $this->authorize('update', $user);
    $user->email = strip_tags($request->email);
    
    if ($user->isDirty('email')) {
      $user->email_verified_at = null;
  }
    $user->save();
    toastr()->success('Email updated',['timeOut'=>1000]);
    return redirect()->route('profile', $user->username);
  }

  public function editname(Request $request, User $user)
  {
    $request->validate([
      "name" => ["required", "min:5", "max:50", "alpha", Rule::unique("users", "name")]
    ]);
    $user->name = strip_tags($request->name);
    $this->authorize('update', $user);
    $user->save();
    toastr()->success('name updated',['timeOut'=>1000]);
    return redirect()->route('profile', $user->username);
  }

  public function editpassword(Request $request, User $user)
  {
    $request->validate([
      "current_password"=>["required"],
      "password" => ["alpha_num", "min:8", "max:32", "confirmed"]
    ]);

    if (!Hash::check($request->current_password, $user->password)) {
      toastr()->error('Current password is incorrect',['timeOut'=>1000]);
      return back();
  }
    $user->password = bcrypt($request->password);
    $this->authorize('update', $user);
    $user->save();
    toastr()->success('password updated',['timeOut'=>1000]);
    return redirect()->route('profile', $user->username);
  }

  public function editphone(Request $request, User $user)
  {
    $request->validate([
      "phone" => ["min:8", Rule::unique("users", "phone")]
    ]);
    $user->phone = strip_tags($request->phone);
    $this->authorize('update', $user);
    $user->save();
    toastr()->success('phone updated',['timeOut'=>1000]);
    return redirect()->route('profile', ['user' => $user->username]);
  }

  public function useraddbio(User $user,Request $request){
   $request->validate([
    'bio'=>'min:5|string|'
   ]);
   $user->bio = strip_tags($request->bio);
   $this->authorize('update',$user);
   $user->save();
   toastr()->success('Bio updated',['timeOut'=>1000]);
   return redirect()->route('profile', ['user' => $user->username]);
  }

  public function deleteaccount(Request $request,User $user){
    $request->validate([
      'check_pass'=>"required|alpha_num|min:8|max:32"
    ]);
  
    if (!Hash::check($request->check_pass, $user->password)) {
      toastr()->error('password is incorrect',['timeOut'=>1000]);
      return back();
  }
  $this->authorize('delete',$user);
  $user->delete();
  auth()->logout();
  toastr()->success('Account deleted successfuly',['timeOut'=>1000]);
  return redirect()->route('login');
  }
}
