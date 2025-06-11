<?php

namespace App\Http\Controllers;


use App\Helpers\MetaHelpers;
use App\Http\Middleware\CheckIfBlocked;
use App\Models\ProfileView;
use App\Models\User;
use App\Services\ProfileViewService;
use App\Services\UserActivityService;

class ProfileController extends Controller
{
  public function __construct(protected ProfileViewService $view,protected UserActivityService $activity)
  {
    $this->middleware(['auth','verified',CheckIfBlocked::class]);
  }
  public function Home(User $user)
  {
    $user = User::where('username', $user->username)->firstOrFail();
    $viewer = auth()->user();
    $this->view->createView($user,$viewer);
    
    $posts = $user->post()->latest()->get();
    
    $meta = MetaHelpers::generateDefault("{$user->name}'s Profile | Blog-Page","{$user->name} profile page connect with him");
    return view('profileuser.profile', array_merge(
      ['posts' => $posts],
      $this->ProfileData($user, 'home', $meta)
    ));
  }
  
  public function activity(User $user){
    
  $user = User::where('username', $user->username)->firstOrFail();
  $activities = $this->activity->getUserActivities($user);
  
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


}
