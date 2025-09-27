<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Middleware\CheckIfBlocked;
use App\Models\Post;
use Illuminate\Http\Request;

class PinController extends Controller
{
      public function __construct(){
      $this->middleware(['auth','verified',CheckIfBlocked::class]);
    }
    public function togglePin(Post $post){
      $this->authorize('update', $post);
      $pinnedCount = Post::where('user_id', auth()->id())
            ->where('is_pinned', true)
            ->count();

        if ($pinnedCount >= 3) {
            toastr()->error('You can pin a maximum of 3 posts', ['timeOut' => 2000]);
            return back();
        }
      $post->is_pinned = !$post->is_pinned;
      $post->save();
      toastr()->success('Post pin status updated successfully',['timeOut'=>1000]);
      return back();
    }
}
