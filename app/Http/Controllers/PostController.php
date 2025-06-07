<?php

namespace App\Http\Controllers;

use App\Helpers\MetaHelpers;
use App\Http\Middleware\CheckIfBlocked;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Hashtag;
use App\Models\Post;
use App\Services\PostHashtagsService;
use App\Services\PostService;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Str;



class PostController extends Controller
{
  use ImageUploadTrait;
  public function __construct()
  {
    $this->middleware(['auth', 'verified', CheckIfBlocked::class]);
    $this->middleware('password.confirm')->only('editpost');
  }

  public function blogpost(Request $request, PostService $sort)
  {

    $sortoption = $request->get('sort', 'latest');
    $posts = Post::query()
      ->with(['user:id,username,avatar', 'hashtags:id,name'])
      ->withCount('likes','totalcomments');

    $sorted = $sort->sortedPosts($posts, $sortoption);
    $posts = $sorted->paginate(5)->withQueryString();

    $hashtags = Hashtag::withCount('posts')->get();

    $meta_keywords = Hashtag::with('posts')->latest()->first();
    $meta = MetaHelpers::generateDefault('Blog-Post | Jamal',
    'welcome to blog post',
    $meta_keywords->pluck('name')->take(4)->toArray());

    return view('blog', array_merge([
      'tags' => $hashtags,
      'posts' => $posts,
      'sorts' => $sortoption,
      'authFollowings' => auth()->user()->load('followings')->followings->pluck('id')->toArray()
    ],$meta)
      
    );
  }

  public function createpage()
  {
    $allhashtags = Hashtag::pluck('name');

    $meta = MetaHelpers::generateDefault('Create-post | Blog-Post',
    'create your own post ',
    $allhashtags->take(4)->toArray());

    return view('create', array_merge([
      'allhashtags' => $allhashtags
    ],$meta)
  );
  }


  public function create(CreatePostRequest $request,PostHashtagsService $tagsservice)
  {
    
    $fields = $request->validated();

    $fields['title'] = htmlspecialchars(strip_tags($fields['title']));
    $allow_comments = $request->has('enabled') ? 1 : 0;
    $imageslug = Str::slug($fields['title']);

    $newimage = $this->uploadImage($request->file('image'), $imageslug);

    $post = Post::create([
      'title' => $request->input('title'),
      'description' => $request->input('description'),
      'image_path' => $newimage,
      'allow_comments' => $allow_comments,
      'user_id' => auth()->user()->id
    ]);

    if (request()->filled('hashtag')) {
      $tagsservice->attachhashtags($post,$request->input('hashtag'));
  }

    toastr()->success('posted successfuly',['timeOut'=>1000]);

    return redirect('/blog');
  }

  public function delete($slug)
  {

    $post = Post::where('slug', $slug)->firstOrFail();
    $this->authorize('delete', $post);
    $post->delete();
    if (auth()->user()->is_admin) {
      toastr()->success('Post deleted successfully',['timeOut'=>1000]);
      return redirect('/admin-panel');
    } else {
      toastr()->success('Post deleted successfully',['timeOut'=>1000]);
      return redirect('/blog');
    }
  }
  public function editpost($slug)
  {
    $post = Post::where('slug', $slug)->firstOrFail();
    $this->authorize('view', $post);

    $hashtags = $post->hashtags()->pluck('name')->implode(', ');
    $allhashtags = Hashtag::pluck('name');
    
    $meta = MetaHelpers::generateMetaForPosts($post);
    return view('updatepost', array_merge([
      'post' => $post,
      'hashtags' => $hashtags,
      'allhashtags' => $allhashtags,
    ],$meta));
  }

  public function update($slug, UpdatePostRequest $request,PostHashtagsService $tags)
  {
    $post = Post::where('slug', $slug)->firstOrFail();
    $this->authorize('update', $post);

    $fields = $request->validated();
    $allow_comments = $request->has('enabled') ?? false;
    $isFeatured = $request->has('featured') ?? false;

    $post->title = $fields['title'];
    $post->description = $fields['description'];
    $post->allow_comments = $allow_comments;
    $post->is_featured = $isFeatured;

   $tags->syncHashtags($post,$fields['hashtag'] ?? '');

    $post->save();
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


      $meta_keywords = collect($posts->items())
      ->flatMap(fn ($post) => $post->hashtags->pluck('name'))
      ->unique()
      ->implode(', ');

       $meta = MetaHelpers::generateDefault('Saved-Posts | Blog-Post','Saved post page where users save posts here',[$meta_keywords]);

    return view('getsavedposts',array_merge([
      'posts' => $posts,
      'authFollowings' => auth()->user()->load('followings')->followings->pluck('id')->toArray()
    ],$meta));
  }
}
