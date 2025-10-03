<?php

namespace App\Http\Controllers;

use App\Events\ReplyCommentEvent;
use App\Http\Middleware\CheckIfBlocked;
use App\Models\Comment;
use App\Models\Post;
use App\Services\ViewPostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth','verified',CheckIfBlocked::class]);
  }
   public function loadMore(Post $post, ViewPostService $viewPostService)
{
    $page = request()->get('page', 1);
    $comments = $viewPostService->getPaginatedComments($post, $page, 5);
    
    if (request()->ajax()) {
        $html = view('comments.comments', ['comments' => $comments])->render();
        
        return response()->json([
            'html' => $html,
            'hasMore' => $comments->hasMorePages(),
            'nextPage' => $comments->currentPage() + 1
        ]);
    }
    
    abort(404);
}
    public function createComment(Post $post,Request $request){
      $fields = $request->validate([
        'content'=>'required|string|max:255',
        'parent_id'=>'nullable|exists:comments,id'
      ]);

    
      $fields['content']=strip_tags($fields['content']);
      $fields['user_id']=auth()->id();
      $fields['post_id']=$post->id;

       if(!$post->allow_comments){
        return response()->json([
          'error'=>'comments disabled on post'
        ]);
       }
      $comment = $post->comments()->create($fields);

      return response()->json([
        'commented'=>true,
        'html' => view('comments.comments', ['comments' => [$comment]])->render()
      ]);
    }

public function reply(Comment $comment, Request $request){
    $fields = $request->validate([
        'content'=>'required|string|max:255',
        'parent_id'=>'required|exists:comments,id'
      ]);
   try{
      // cannot reply to own reply
      if ($comment->user_id == auth()->id() && $comment->parent_id !== null) {
    
        return response()->json([
          'error' =>'Cannot reply to your own reply'
        ]);
    }
    // maximum 3 replies allowed
    $replyCount = Comment::where('parent_id',$fields['parent_id'])->count();
    if($replyCount >= 3){
      return response()->json([
        'error' =>'maximum 3 replies'
      ]);
    }
    // reply once to your parent comment
    $selfReplyCount = Comment::where('user_id', auth()->id()) 
    ->where('parent_id', $comment->id) 
    ->exists();
    
    if ($selfReplyCount) {
  
    return response()->json([
      'error' =>'You can only reply once on comment'
    ]);
}
      $fields['content']=strip_tags($fields['content']);
      $fields['user_id']=auth()->id();
      $fields['post_id']=$comment->post_id;
      
     $reply = Comment::create($fields);

     event(new ReplyCommentEvent($comment, $reply,auth()->user()));

      return response()->json([
        'replied' => true,
        'html' => view('comments.replies',['comments'=>[$reply]])->render()
      ]);
    }catch (\Exception $e) {
        Log::error('error applying reply :'.$e->getMessage());
    }
}
    public function editComment(Request $request,Comment $comment){
      
      $this->authorize('edit',$comment);
      
      
      $fields = $request->validate([
        'content'=>'required|string|max:255',
        'parent_id'=>'nullable|exists:comments,id'
      ]);

    
      $fields['content']=strip_tags($fields['content']);

      $comment->update($fields);
      return response()->json([
        'Edited'=>true
      ]);

    }

    public function deleteComment(Comment $comment){
      $this->authorize('delete',$comment);
      $comment->delete();
      return response()->json([
        'deleted'=>true
      ]);
    }
}
