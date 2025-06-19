<?php

namespace App\Http\Controllers;


use App\Helpers\MetaHelpers;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Middleware\CheckIfBlocked;
use App\Models\Comment;
use App\Models\Hashtag;
use App\Services\FollowService;
use App\Services\PostViewsService;
use App\Services\ViewPostService;

class PublicController extends Controller
{
  public function __construct(
    protected ViewPostService $singlepost,
    protected PostViewsService $views)
  {
    $this->middleware(['auth','verified',CheckIfBlocked::class]);
  }


  public function search(Request $request)
  {
    $fields = $request->validate([
      'search' => 'required|string|max:255'
    ]);
     $sortoption = $request->get('sort', 'latest');
    $postsid = Post::search($fields['search'])->get()->pluck('id');
     
    $posts = Post::whereIn('id',$postsid)
    ->withCount(['likes', 'comments'])
    ->with(['user','hashtags'])
    ->sortby($sortoption)
    ->paginate(5)
    ->withQueryString();

    $hashtags = Hashtag::withCount('posts')->get();
    
    return view('blog', [
      'posts' => $posts,
      'sorts' => $sortoption,
      'searchquery'=>$fields['search'],
      'tags' => $hashtags,
      'authFollowings' => auth()->user()->load('followings')->followings->pluck('id')->toArray()
    ]);
  }

public function togglefollow(User $user,FollowService $service){
  $follower = auth()->user();
  if ($follower->id === $user->id) {
    return response()->json(['error' => 'You cannot follow yourself.'], 400);
}

$attached = $service->toggle($follower,$user);

return response()->json(['attached'=>$attached]);
}

  public function viewpost(Post $post)
  {
    $post = $this->singlepost->getPost($post);
    $this->views->getViews($post);
 
    return view('post', [
       'post' => $post,
       'totalcomments'=> Comment::where('post_id', $post->id)->count(),
       'morearticles' => $post->morearticles,
       'viewwholiked' => $post->viewwholiked,
       'reasons' => $post->reasons,
       'authFollowings' => auth()->user()->load('followings')->followings->pluck('id')->toArray()
    ]);
  }


}
