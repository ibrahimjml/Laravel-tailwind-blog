<?php

namespace App\Http\Controllers;



use App\Models\Post;
use App\Models\User;
use App\Http\Middleware\CheckIfBlocked;
use App\Services\FollowService;
use App\Services\PostService;
use Illuminate\Http\Request;

class PublicController extends Controller
{
  public function __construct(protected PostService $service)
  {
    $this->middleware(['auth','verified',CheckIfBlocked::class]);
  }

public function toggleFollow(User $user,FollowService $service){
  $follower = auth()->user();
  if ($follower->id === $user->id) {
    return response()->json(['error' => 'You cannot follow yourself.'], 400);
}

$attached = $service->toggle($follower,$user);

return response()->json(['attached'=>$attached]);
}

  public function like(Post $post)
  {

    if ($post->is_liked()) {
    $like =  $post->likes()->where('user_id', auth()->user()->id)->first();
    if($like){
      $like->delete();
      $post->decrement('likes_count');
    }
  
      return response()->json(['liked' => false]);
    }
    $post->likes()->create(['user_id' => auth()->user()->id]);
    $post->increment('likes_count');

    return response()->json([
      'liked' => true,
      'likes_count' => $post->likes_count
    ]);
  }

  public function save(Request $request)
  {
    $fields = $request->validate([
      'post_id' => 'required|int'
    ]);
    $postId = $fields['post_id'];
    $savedposts = session('saved-to', []);
    if (in_array($postId, $savedposts)) {
      $savedposts = array_diff($savedposts, [$postId]);
      session(['saved-to' => $savedposts]);
      return response()->json(['status' => 'removed']);
    } else {
      $savedposts[] = $postId;
      session(['saved-to' => $savedposts]);
      return response()->json(['status' => 'added']);
    }
  }

  public function getsavedposts()
  {
    return $this->service->handleSaved();
  }

  


}
