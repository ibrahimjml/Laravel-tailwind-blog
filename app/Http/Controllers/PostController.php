<?php

namespace App\Http\Controllers;


use App\DTOs\CreatePostDTO;
use App\DTOs\UpdatePostDTO;
use App\Http\Middleware\CheckIfBlocked;
use App\Http\Requests\App\CreatePostRequest;
use App\Http\Requests\App\UpdatePostRequest;
use App\Models\Category;
use App\Models\Hashtag;
use App\Models\Post;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Http\Request;



class PostController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth', 'verified', CheckIfBlocked::class]);
    $this->middleware('password.confirm')->only('editpost');
  }

  public function blogpost(Request $request)
  {

    $sortoption = $request->get('sort', 'latest');
    $posts = Post::query()
            ->published()
            ->with(['user:id,username,avatar', 'hashtags:id,name,is_featured','categories:id,name,is_featured'])
            ->withCount('likes','totalcomments')
            ->blogSort($sortoption)
            ->paginate(5)
           ->withQueryString();

    $hashtags = Hashtag::active()
                     ->withCount('posts')
                     ->get();
    $categories = Category::withCount('posts')->get();
    $whoToFollow = User::where('id','!=',auth()->id())
                    ->whereNotIn('id',auth()->user()->followings()->pluck('user_id'))
                    ->inRandomOrder()
                    ->take(5)
                    ->get();
    return view('blog.blog', [
      'tags' => $hashtags,
      'categories' => $categories,
      'users' => $whoToFollow,
      'posts' => $posts,
      'sorts' => $sortoption,
    ]);

  }

  public function createpage()
  {
    $allhashtags = Hashtag::active()->pluck('name');
    $categories = Category::select('id','name')->get();

    return view('create', [
      'allhashtags' => $allhashtags,
      'categories' => $categories
    ]);
  }


  public function create(CreatePostRequest $request,PostService $service)
  {
    $dto = CreatePostDTO::fromAppRequest($request);
    $service->create($dto);
    toastr()->success('posted successfuly',['timeOut'=>1000]);

    return redirect('/blog');
  }

  public function delete($slug)
  {

    $post = Post::published()->whereSlug( $slug)->firstOrFail();
    $this->authorize('delete', $post);
    $post->delete();
    
      toastr()->success('Post deleted successfully',['timeOut'=>1000]);
      return redirect('/blog');
    
  }
  public function editpost($slug)
  {
    $post = Post::published()->whereSlug( $slug)->firstOrFail();
    $this->authorize('view', $post);

    $hashtags = $post->hashtags()->pluck('name')->implode(', ');
    $allhashtags = Hashtag::active()->pluck('name');
    $categories = Category::select('id','name')->get();
    
    return view('updatepost',[
      'post' => $post,
      'hashtags' => $hashtags,
      'allhashtags' => $allhashtags,
      'categories' => $categories
    ]);
  }

  public function update($slug, UpdatePostRequest $request,PostService $service)
  {
    $post = Post::published()->whereSlug( $slug)->firstOrFail();
    $this->authorize('update', $post);
    $dto = UpdatePostDTO::fromAppRequest($request);
    $service->update($post,$dto);

    toastr()->success('Post updated successfully',['timeOut'=>1000]);
    return redirect('/blog');
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

    $getposts = session('saved-to', []);
    $posts = Post::published()
      ->whereIn('id', $getposts)
      ->withCount(['likes', 'comments'])
      ->with(['user', 'hashtags'])
      ->paginate(5);

    return view('getsavedposts',[
      'posts' => $posts,
    ]);
  }
}
