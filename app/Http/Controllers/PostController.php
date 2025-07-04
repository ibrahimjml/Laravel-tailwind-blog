<?php

namespace App\Http\Controllers;


use App\DTOs\CreatePostDTO;
use App\DTOs\UpdatePostDTO;
use App\Http\Middleware\CheckIfBlocked;
use App\Http\Requests\App\CreatePostRequest;
use App\Http\Requests\App\UpdatePostRequest;
use App\Models\Hashtag;
use App\Models\Post;
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
            ->with(['user:id,username,avatar', 'hashtags:id,name'])
            ->withCount('likes','totalcomments')
            ->sortby($sortoption)
            ->paginate(5)
           ->withQueryString();

    $hashtags = Hashtag::withCount('posts')->get();

    return view('blog', [
      'tags' => $hashtags,
      'posts' => $posts,
      'sorts' => $sortoption,
    ]);

  }

  public function createpage()
  {
    $allhashtags = Hashtag::pluck('name');

    return view('create', [
      'allhashtags' => $allhashtags
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

    $post = Post::whereSlug( $slug)->firstOrFail();
    $this->authorize('delete', $post);
    $post->delete();
    
      toastr()->success('Post deleted successfully',['timeOut'=>1000]);
      return redirect('/blog');
    
  }
  public function editpost($slug)
  {
    $post = Post::whereSlug( $slug)->firstOrFail();
    $this->authorize('view', $post);

    $hashtags = $post->hashtags()->pluck('name')->implode(', ');
    $allhashtags = Hashtag::pluck('name');
    
    return view('updatepost',[
      'post' => $post,
      'hashtags' => $hashtags,
      'allhashtags' => $allhashtags,
    ]);
  }

  public function update($slug, UpdatePostRequest $request,PostService $service)
  {
    $post = Post::whereSlug( $slug)->firstOrFail();
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
    $posts = Post::whereIn('id', $getposts)
      ->withCount(['likes', 'comments'])
      ->with(['user', 'hashtags'])
      ->paginate(5);

    return view('getsavedposts',[
      'posts' => $posts,
    ]);
  }
}
