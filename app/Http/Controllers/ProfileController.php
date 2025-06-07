<?php

namespace App\Http\Controllers;

use App\Events\ProfileViewedEvent;
use App\Helpers\MetaHelpers;
use App\Http\Middleware\CheckIfBlocked;
use App\Models\ProfileView;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth','verified',CheckIfBlocked::class]);
  }
  private function ProfileData(User $user, string $section, array $meta = [])
{
    return array_merge([
        'user' => $user,
        'section' => $section,
        'postcount' => $user->post()->count(),
        'likescount' => $user->post()->withCount('likes')->get()->sum('likes_count'),
        'commentscount' => $user->post()->withCount('comments')->get()->sum('comments_count'),
        'profileviews' => ProfileView::where('profile_id', $user->id)->with('viewer')->get(),
    ], $meta);
}
  public function Home(User $user)
  {
    $user = User::where('username', $user->username)->firstOrFail();
    $viewer = auth()->user();

     // create profile view
     if ($viewer->id !== $user->id && !$viewer->is_admin) {
      ProfileView::firstOrCreate([
          'viewer_id' => auth()->id(),
          'profile_id' => $user->id,
      ]);
  }
   event(new ProfileViewedEvent($user, $viewer));
  
  $posts = $user->post()->latest()->get();

    $meta = MetaHelpers::generateDefault("{$user->name}'s Profile | Blog-Page","{$user->name} profile page connect with him");
    return view('profileuser.profile', array_merge(
      ['posts' => $posts],
      $this->ProfileData($user, 'home', $meta)
    ));
  }

public function activity(User $user){
  $user = User::where('username', $user->username)->firstOrFail();

  $posts = $user->post()->select('title','created_at')->get()
  ->map(function($post){
      return [
          'type' => 'Posted',
          'title' => $post->title,
          'date' => $post->created_at,
      ];
  })
  ->toArray();

$comments = $user->comments()->select('content','created_at','parent_id')->get()
  ->map(function($comment){
      return [
          'type' => $comment->parent_id ? 'Replied' : 'Commented',
          'title' => $comment->content,
          'date' => $comment->created_at,
      ];
  })
  ->toArray();

  $merged = collect($posts)->merge($comments);
  $activities = $merged->sortByDesc('date')
              ->groupBy(fn($activity)=>Carbon::parse($activity['date'])->format('M j Y'));
  
  $meta = MetaHelpers::generateDefault("{$user->name}'s Activity | Blog-Page", "{$user->name} recent activity.");
  return view('profileuser.profile', array_merge(
    ['activities' => $activities],
    $this->ProfileData($user, 'activity', $meta)
  ));
}
public function aboutme(User $user){

$user = User::where('username', $user->username)->firstOrFail();

  $meta = MetaHelpers::generateDefault("About {$user->name} | Blog-Page", "{$user->name} about section.");
  return view('profileuser.profile', $this->ProfileData($user, 'about', $meta));
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
      "email" => ["required", "email", "min:5", "max:50", Rule::unique(User::class)->ignore($user->id)]
    ]);

    $this->authorize('update', $user);
    $newemail = trim(strip_tags($request->email));
      if ($user->email === $newemail) {
        toastr()->info('Email is already up to date.', ['timeOut' => 1000]);
        return redirect()->back();
    }
    $user->email = $newemail;
    $user->email_verified_at = null;
    $user->save();

    toastr()->success('Email updated',['timeOut'=>1000]);
    return redirect()->route('profile', $user->username);
  }

  public function editname(Request $request, User $user)
  {
    $request->validate([
      "name" => ["required", "min:5", "max:50", "alpha", Rule::unique("users", "name")->ignore($user->id)]
    ]);
    $newname = trim(strip_tags($request->name));
      if ($user->name === $newname) {
        toastr()->info('Name is already up to date.', ['timeOut' => 1000]);
        return redirect()->back();
    }
    $this->authorize('update', $user);
    $user->name = $newname;
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
      "phone" => ['required', 'regex:/^\+\d{8,15}$/', Rule::unique(User::class)->ignore($user->id)]
    ],[
      'phone.regex' => 'The phone number must include a valid country code.'
    ]);
    $newPhone = trim(strip_tags($request->phone));
      if ($user->phone === $newPhone) {
        toastr()->info('Phone number is already up to date.', ['timeOut' => 1000]);
        return redirect()->back();
    }
    $this->authorize('update', $user);
    $user->phone = $newPhone;
    $user->save();
    toastr()->success('phone updated',['timeOut'=>1000]);
    return redirect()->route('profile', ['user' => $user->username]);
  }

  public function useraddbio(User $user,Request $request){
   $request->validate([
    'bio'=>'nullable|min:5|string'
   ]);
   $user->bio = strip_tags($request->bio);
   $this->authorize('update',$user);
   $user->save();
   toastr()->success('Bio updated',['timeOut'=>1000]);
   return redirect()->route('profile', ['user' => $user->username]);
  }

  public function useraboutme(User $user,Request $request){
   $request->validate([
    'about'=>'nullable|string'
   ]);
   $aboutme = strip_tags($request->about);
   $user->aboutme = $aboutme !== '' ? $aboutme : null;
      if(!$user->isDirty('aboutme')){
      toastr()->info('No changes detected.', ['timeOut' => 1000]);
      return back();
   }
   $this->authorize('update',$user);
   $user->save();
   toastr()->success('aboutme updated',['timeOut'=>1000]);
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
