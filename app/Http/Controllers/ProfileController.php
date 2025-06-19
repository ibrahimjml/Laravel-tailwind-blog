<?php

namespace App\Http\Controllers;

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
    $viewer = auth()->user();
    $this->view->createView($user,$viewer);
    
    $posts = $user->post()->latest()->get();
    
    return view('profileuser.profile', array_merge(
      ['posts' => $posts],
      $this->ProfileData($user, 'home')
    ));
  }
  
  public function activity(User $user){
  
  $activities = $this->activity->getUserActivities($user);
  
  return view('profileuser.profile', array_merge(
    ['activities' => $activities],
    $this->ProfileData($user, 'activity')
  ));
}
public function aboutme(User $user){
  return view('profileuser.profile', $this->ProfileData($user, 'about'));
}
private function ProfileData(User $user, string $section)
{
  return [
      'user' => $user,
      'section' => $section,
      'postcount' => $user->post()->count(),
      'likescount' => $user->post()->withCount('likes')->get()->sum('likes_count'),
      'commentscount' => $user->post()->withCount('comments')->get()->sum('comments_count'),
      'profileviews' => ProfileView::where('profile_id', $user->id)->with('viewer')->get(),
  ];
}


}
