<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckIfBlocked;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

use function Laravel\Prompts\search;

class PublicController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth','verified',CheckIfBlocked::class]);
  }

  public function index()
  {
    return view('index');
  }

  public function search(Request $request)
  {
    $fields = $request->validate([
      'search' => 'required|min:2|max:120'
    ]);
    $posts = Post::search($fields['search'])->paginate(5);

    $noResults = $posts->isEmpty();

    return view('blog', [
      'posts' => $posts,
      'noResults' => $noResults,
      'sorts' => 'latest'
    ]);
  }

  public function viewpost($slug)
  {
    $post = Post::where('slug', $slug)->first();
    $comments = Comment::orderBy('created_at', 'desc')->get();
    return view('post', [
       'post' => $post,
       'comments' => $comments
      ]);
  }

  public function viewpostByuser(User $user)
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
       'commentscount' => $commentCount
      ]);
  }

  public function editpage(User $user)
  {
    $this->authorize('view', $user);
    return view('edit-avatar', compact('user'));
  }

  public function edit(Request $request, User $user)
  {
    $fields = $request->validate([
      'avatar' => 'required|image|mimes:png,jpeg,jpg|max:5048'
    ]);

    $path = $request->file('avatar')->store('images', 'public');

    $this->authorize('update', $user);
    $user->avatar = $path;
    $user->save();

    return redirect()->route('profile',  $user->username)->with('success', 'Image updated successfully.');
    
  }
  public function destroyavatar(User $user){
    if($user->avatar && $user->avatar !== 'default.jpg'){
      Storage::delete('public/images'.$user->avatar);
    }
    $this->authorize('delete',$user);
    $user->avatar="default.jpg";
    $user->save();
    return redirect()->route('profile', $user->username)->with('success', 'Avatar deleted.');
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

    return redirect()->route('profile', $user->username)->with('success', 'Email updated');
  }

  public function editname(Request $request, User $user)
  {
    $request->validate([
      "name" => ["required", "min:5", "max:50", "alpha", Rule::unique("users", "name")]
    ]);
    $user->name = strip_tags($request->name);
    $this->authorize('update', $user);
    $user->save();

    return redirect()->route('profile', $user->username)->with('success', 'name updated');
  }

  public function editpassword(Request $request, User $user)
  {
    $request->validate([
      "current_password"=>["required"],
      "password" => ["alpha_num", "min:8", "max:32", "confirmed"]
    ]);

    if (!Hash::check($request->current_password, $user->password)) {
      return back()->with(['error' => 'Current password is incorrect.']);
  }
    $user->password = bcrypt($request->password);
    $this->authorize('update', $user);
    $user->save();
    return redirect()->route('profile', $user->username)->with('success', 'password updated');
  }

  public function editphone(Request $request, User $user)
  {
    $request->validate([
      "phone" => ["min:8", Rule::unique("users", "phone")]
    ]);
    $user->phone = strip_tags($request->phone);
    $this->authorize('update', $user);
    $user->save();

    return redirect()->route('profile', ['user' => $user->username])->with('success', 'phone updated');
  }

  public function useraddbio(User $user,Request $request){
   $request->validate([
    'bio'=>'min:5|string|'
   ]);
   $user->bio = strip_tags($request->bio);
   $this->authorize('update',$user);
   $user->save();
   return redirect()->route('profile', ['user' => $user->username])->with('success', 'Bio updated');
  }

  public function deleteaccount(Request $request,User $user){
    $request->validate([
      'check_pass'=>"required|alpha_num|min:8|max:32"
    ]);
  
    if (!Hash::check($request->check_pass, $user->password)) {
      return back()->with(['error' => 'password is incorrect']);
  }
  $this->authorize('delete',$user);
  $user->delete();
  auth()->logout();
  return redirect()->route('login')->with('success','Account deleted successfuly');
  }
}
