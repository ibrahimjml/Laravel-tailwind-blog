<?php

namespace App\Http\Controllers;

use App\Enums\ReportReason;
use App\Http\Middleware\CheckIfBlocked;
use App\Models\Post;
use App\Models\PostReport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class PostReportController extends Controller
{
  public function __construct(){
      $this->middleware(['auth', 'verified', CheckIfBlocked::class]);
  }
      public function report_post(Post $post,Request $request)
  {
    $this->authorize('report',$post);
    $fields = $request->validate([
      'report_reason' => ['required',new Enum(ReportReason::class)],
      'other' => 'nullable|string'
    ]);

    $exists = PostReport::where('user_id',auth()->id())
    ->where('post_id',$post->id)
    ->exists();
    if ($exists) {
        toastr()->error('you already reported this post',['timeOut'=>1000]);
      return back();
    };
    PostReport::create([
      'user_id'=> auth()->id(),
      'post_id'=>$post->id,
      'reason'=>ReportReason::from($fields['report_reason']),
      'other'=> $request->report_reason === ReportReason::Other->value ? $fields['other'] : null
    ]);
      toastr()->success('post report success',['timeOut'=>1000]);
    return back();
  }
}
