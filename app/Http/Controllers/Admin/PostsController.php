<?php

namespace App\Http\Controllers\Admin;

use App\DTOs\CreatePostDTO;
use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\CreatePostRequest;
use App\Models\{Category, Hashtag, Post};
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class PostsController extends Controller
{
      public function __construct(){
          $this->middleware('permission:post.view')->only('posts');
          $this->middleware('permission:post.feature')->only('toggleFeature');
      }
    public function posts(Request $request)
  {
    $sort = $request->get('sort', 'latest'); 
    $choose = $sort === 'oldest' ? 'ASC' : 'DESC';
    $featured = (bool) $request->get('featured',false);
    $reported = (bool) $request->get('reported',false);
    $posts = Post::with(['user','allHashtags','categories'])
          ->search($request->get('search'))
          ->withCount('totalcomments')
          ->when($sort && in_array($sort, array_map(fn($case) => $case->value, PostStatus::cases())), fn($q) => $q->status($sort))
          ->when($featured, fn($q) => $q->where('is_featured', 1))
          ->when($reported, fn($q) => $q->where('is_reported', 1))
          ->orderBy('created_at', $choose)
          ->paginate(7,['*'],'admin_posts')
          ->withQuerystring();


    return view('admin.posts.posts',[
      'posts'=>$posts,
      'filter'=>$request->only('search','sort','featured')
    ]);
  }
public function featuredPage(){
  return view('admin.featuredposts',[
    'allhashtags' => Hashtag::pluck('name'),
    'categories' => Category::select('id','name')->get()
  ]);
}

  public function createFeature(CreatePostRequest $request,PostService $service){
  
 $dto = CreatePostDTO::fromAppRequest($request);
 $service->create($dto);  
toastr()->success('post feature created',['timeOut'=>1000]);
return to_route('admin.posts');
  }
  public function editStatus(Post $post,Request $request)
  {
    $fields = $request->validate([
      'status' => ['required',new Enum(PostStatus::class)]
    ]);
    $status = PostStatus::from($fields['status']);

    $post->published_at = null;
    $post->banned_at = null;
    $post->trashed_at = null;

     match ($status) {
        PostStatus::PUBLISHED => $post->published_at = now(),
        PostStatus::BANNED    => $post->banned_at = now(),
        PostStatus::TRASHED   => $post->trashed_at = now(),
        default               => null, 
    };
     $post->status = $status;
     $post->save();
     
    return response()->json([
      'updated' => true,
      'message' => "status updated {$post->status->value}"
     ],200);
  }

   public function toggleFeature(Post $post)
 {
  $this->authorize('make_feature',$post);
  $post->update(['is_featured'=>!$post->is_featured]);
  if($post->is_featured){
    toastr()->success('post featured success',['timeOut'=>1000]);
  }else{
      toastr()->success('post unfeatured success',['timeOut'=>1000]);
  }
  return redirect()->back();
 }
}
