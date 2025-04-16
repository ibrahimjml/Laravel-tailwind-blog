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
    toastr()->success('comment posted',['timeOut'=>1000]);

      return back();
    }

    public function deletecomment(Comment $comment){
      $this->authorize('delete',$comment);
      $comment->delete();
      toastr()->success('comment deleted',['timeOut'=>1000]);
      return redirect()->back();
    }
}
