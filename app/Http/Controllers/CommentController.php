<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function comment(Post $post,Request $request){
      $fields = $request->validate([
        'content'=>'required|string|max:255',
        'parent_id'=>'nullable|exists:comments,id'
      ]);

    
      $fields['content']=strip_tags($fields['content']);
      $fields['user_id']=auth()->id();
      $fields['post_id']=$post->id;

    Comment::create($fields);

      
     session()->flash('success','comment posted');
      return back();
    }

    public function deletecomment(Comment $comment){

      $comment->delete();
      return redirect()->back()->with('success','comment deleted');
    }
}
