<?php

namespace App\Http\Controllers;

use App\Helpers\MetaHelpers;
use App\Http\Middleware\CheckIfBlocked;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Mail\postlike;
use App\Models\Hashtag;
use App\Models\Post;
use App\Notifications\FollowingPostCreatedNotification;
use App\Notifications\LikesNotification;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;


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
      ->withCount('likes','totalcomments');

    switch ($sortoption) {
      case 'latest';
        $posts->latest();
        break;

      case 'oldest';
        $posts->oldest();
        break;

      case 'mostliked':
        $posts->withCount('likes')->orderByDesc('likes_count');
        break;

        case 'followings':
        $followings = auth()->user()->followings->pluck('id');
        $posts->whereIn('user_id',$followings);
          break;

        case 'featured':
          $posts->featured();
          break;

      case 'hashtagtrend':

        $trendingHashtag = Hashtag::withCount('posts')
          ->having('posts_count','>',0)
          ->orderByDesc('posts_count')
          ->first();

        if ($trendingHashtag) {

          $posts->whereHas('hashtags', function ($query) use ($trendingHashtag) {
            $query->where('hashtags.id', $trendingHashtag->id);
          });
        } else {

          $posts->whereRaw('0 = 1');
        }
        break;

      default:
        $posts->latest();
        break;
    }
    $posts = $posts->paginate(5)->appends(['sort' => $sortoption]);

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


  public function create(CreatePostRequest $request)
  {
    
    $fields = $request->validated();

    $fields['title'] = htmlspecialchars(strip_tags($fields['title']));
    $allow_comments = $request->has('enabled') ? 1 : 0;
    $slug = Str::slug($fields['title']);


    $newimage = uniqid() . '-' . $slug . '.' . $fields['image']->extension();
    $image = Image::read($request->file('image'))
    ->resize(1300, 600)
    ->encode();
    Storage::disk('public')->put("uploads/{$newimage}", $image);

    $post = Post::create([
      'title' => $request->input('title'),
      'description' => $request->input('description'),
      'slug' => $slug,
      'image_path' => $newimage,
      'allow_comments' => $allow_comments,
      'user_id' => auth()->user()->id
    ]);
    toastr()->success('posted successfuly',['timeOut'=>1000]);

    $followers = auth()->user()->followers;
    foreach($followers as $follower){
      $follower->notify(new FollowingPostCreatedNotification($follower,auth()->user(),$post));
    }
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

  public function update($slug, UpdatePostRequest $request)
  {
    $post = Post::where('slug', $slug)->firstOrFail();
    $this->authorize('update', $post);
    $allow_comments = $request->has('enabled') ?? false;
    $isFeatured = $request->has('featured') ?? false;

    $fields = $request->validated();

    $post->title = $fields['title'];
    $post->description = $fields['description'];
    $post->allow_comments = $allow_comments;
    $post->is_featured = $isFeatured;

    if (!empty($fields['hashtag'])) {
      $hashtagNames = array_filter(array_map('trim', explode(',', $fields['hashtag'])));
      $hashtagIds = [];

      foreach ($hashtagNames as $name) {
          $hashtag = Hashtag::firstOrCreate(['name' => strip_tags(trim($name))]);
          $hashtagIds[] = $hashtag->id;
      }


      $post->hashtags()->sync($hashtagIds);
    } else {
      $post->hashtags()->detach();
    }

    $post->save();
    toastr()->success('Post updated successfully',['timeOut'=>1000]);
    return redirect('/blog');
  }

  public function like(Post $post)
  {

    if ($post->is_liked()) {
      $post->likes()->where('user_id', auth()->user()->id)->delete();

      // auto delete like notification when unlike 
      DatabaseNotification::where('type',LikesNotification::class)
      ->where('notifiable_id', $post->user->id)
      ->whereJsonContains('data->post_id', $post->id)
      ->whereJsonContains('data->user_id', auth()->user()->id)
      ->delete();

      return response()->json(['liked' => false]);
    }
    $post->likes()->create(['user_id' => auth()->user()->id]);

    Mail::to($post->user)->queue(new postlike($post->user, auth()->user(), $post));
    $post->user->notify(new LikesNotification(auth()->user(),$post));

    return response()->json(['liked' => true]);
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
