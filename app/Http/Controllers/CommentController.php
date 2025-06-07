<?php

namespace App\Http\Controllers;

use App\Events\ReplyCommentEvent;
use App\Http\Middleware\CheckIfBlocked;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;


class CommentController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth','verified',CheckIfBlocked::class]);
  }

    public function comment(Post $post,Request $request){
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
    $selfReplyCount = Comment::where('parent_id', $fields['parent_id'])
    ->where('user_id', auth()->id()) 
    ->where('parent_id', $comment->id) 
    ->exists();
    
    if ($selfReplyCount) {
  
    return response()->json([
      'error' =>'You can only reply once to your own comment'
    ]);
}
      $fields['content']=strip_tags($fields['content']);
      $fields['user_id']=auth()->id();
      $fields['post_id']=$comment->post_id;
      
     $reply = Comment::create($fields);
     event(new ReplyCommentEvent($reply, $comment));

      toastr()->success('Reply added successfully',['timeOut'=>1000]);
      return response()->json([
        'replied' => true,
        'html' => view('comments.replies',['comments'=>[$reply]])->render()
      ]);
}
    public function editcomment(Request $request,Comment $comment){
      
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

    public function deletecomment(Comment $comment){
      $this->authorize('delete',$comment);
      $comment->delete();
      return response()->json([
        'deleted'=>true
      ]);
    }
}
