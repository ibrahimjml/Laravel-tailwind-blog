<?php

namespace App\Http\Controllers;


use App\DTOs\PostFilterDTO;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Middleware\CheckIfBlocked;
use App\Models\Category;
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
    $dto = PostFilterDTO::fromRequest($request);
    $postsid = Post::search($dto->search)->get()->pluck('id');
    $page = request()->get('page', 1);
    $perPage = request('perpage',5);

    $posts = Post::published()
             ->whereIn('id',$postsid)
             ->withCount(['likes', 'comments'])
             ->with(['user','hashtags'])
             ->blogSort($dto->sort)
             ->paginate($perPage,['*'],'search',$page)
             ->withQueryString();

    if(request()->ajax()){
      $html = view('blog.partials.posts',['posts' => $posts])->render();
      return response()->json([
        'html' => $html,
        'searchquery'=>$dto->search,
        'hasMore' => $posts->hasMorePages(),
        'nextPage' => $posts->currentPage() + 1
      ]);
    }  

    return view('search', [
      'posts' => $posts,
      'sorts' => $dto->sort,
      'searchquery'=>$dto->search,
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
    // generate post view
    $this->views->getViews($post);
    $comments = $this->singlepost->getPaginatedComments($post, 1, 5);

    
    return view('post', [
       'post' => $post,
       'comments' => $comments,
       'latestblogs' => $post->latestblogs,
       'morearticles' => $post->morearticles,
       'viewwholiked' => $post->viewwholiked,
       'reasons' => $post->reasons,
    ]);
  }


}
