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
use App\Services\PostService;
use App\Services\PostviewService;

class PublicController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth','verified',CheckIfBlocked::class]);
  }


  public function search(Request $request,PostService $sort)
  {
    $fields = $request->validate([
      'search' => 'required|string|max:255'
    ]);
     $sortoption = $request->get('sort', 'latest');
    $postsid = Post::search($fields['search'])->get()->pluck('id');
     
    $posts = Post::whereIn('id',$postsid)
    ->withCount(['likes', 'comments'])
    ->with(['user','hashtags']);

   $posts = $sort->sortedPosts($posts, $sortoption)
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

  public function viewpost($slug,PostviewService $postview)
  {
    $post = Post::whereSlug( $slug)->firstOrFail();
    $post->load(['user','hashtags','comments','viewers:id,name,username,avatar']);
    $postview->getPostView($post);
 $morearticles = Post::query()
  ->with(['user'=> function ($query){
    $query->select('id','name','username','avatar');
  }])
 ->where('user_id',$post->user_id)
 ->where('id','!=',$post->id)
 ->take(3)
 ->get();

 $viewwholiked = $post->likes()
 ->with('user:id,name,username,avatar')
 ->get();
 
    $meta = MetaHelpers::generateMetaForPosts($post);
    return view('post', array_merge([
       'post' => $post,
       'totalcomments'=> Comment::where('post_id', $post->id)->count(),
       'morearticles' => $morearticles,
       'viewwholiked' => $viewwholiked,
       'authFollowings' => auth()->user()->load('followings')->followings->pluck('id')->toArray()
    ],$meta));
  }


}
