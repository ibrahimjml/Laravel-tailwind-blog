<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostViewResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostControllerApi extends Controller
{
    public function __construct()
    {
      $this->middleware('auth:sanctum')->except('viewpost','blog');
    }

    public function blog(){
      return PostResource::collection(Post::paginate(5));
    }

    public function viewpost(Post $post){
      return new PostViewResource($post);
    }

    public function create(PostRequest $request){
  
    $post = Post::create([
      'user_id' => auth()->id(),
      'title' => $request->input('title'),
      'description' => $request->input('description'),
      'slug' => Str::slug($request->input('title'))
  ]);
      return response([
        'data' => new PostViewResource($post)
    ], 200);
    }

    public function update(PostUpdateRequest $request,Post $post){

        $this->authorize('update',$post);

        $post->update([
          'title' => $request->input('title'),
          'description' => $request->input('description'),
          'slug' => Str::slug($request->input('title'))
      ]);

      return response([
          'data' => new PostViewResource($post)
      ], 200);
  }
    public function destroy(Post $post) {
      $this->authorize('delete',$post);
    $post->delete();

    return response([
        'data' => 'Post has been successfully deleted.'
    ], 200);
}

}

