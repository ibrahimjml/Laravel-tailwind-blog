<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckIfBlocked;
use App\Mail\EmailComment;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

    $comment = $post->comments()->create($fields);

    Mail::to($post->user)->queue(new EmailComment($post->user,$comment->user,$post));
    $comment->update($fields);
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

      $fields['content']=strip_tags($fields['content']);
      $fields['user_id']=auth()->id();
      $fields['post_id']=$comment->post_id;
      Comment::create($fields);
      toastr()->success('Reply added successfully',['timeOut'=>1000]);
      return back();
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
