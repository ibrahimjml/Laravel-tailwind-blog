<?php

namespace App\Http\Controllers;

use App\DTOs\ReportsDTO;
use App\Http\Middleware\CheckIfBlocked;
use App\Models\Post;
use App\Services\ReportsService;
use Illuminate\Http\Request;


class ReportPostController extends Controller
{
  public function __construct(protected ReportsService $service){
      $this->middleware(['auth', 'verified', CheckIfBlocked::class]);
  }
      public function report_post(Post $post,Request $request)
  {
    $this->authorize('report',$post);
    $dto = ReportsDTO::fromRequest($request);

     if (! $this->service->reportPost($post, $dto)) {
        toastr()->error('You already reported this post', ['timeOut' => 1000]);
        return back();
    }
      toastr()->success('post report success',['timeOut'=>1000]);
      
    return back();
  }
}
