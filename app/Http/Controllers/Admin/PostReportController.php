<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ReportStatus;
use App\Events\ReportStatusUpdateEvent;
use App\Http\Controllers\Controller;
use App\Models\PostReport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class PostReportController extends Controller
{
      public function __construct()
{
    $this->middleware('permission:postreport.view')->only('post_reports');
    $this->middleware('permission:postreport.delete')->only('report_delete');
    $this->middleware('permission:postreport.status')->only('toggle_status');
  
}
      public function post_reports(Request $request)
  {
    $sort = $request->get('sort'); 
    $reports = PostReport::with(['user','post.user'])
                 ->when($sort, fn($q) => $q->where('status', $sort))
                 ->latest()
                 ->paginate(10);
   
    return view('admin.post-reports',['reports'=>$reports]);
  }
  public function report_delete(PostReport $report)
  {
    $report->delete();
    toastr()->success('report deleted',['timeOut'=> 1000]);
    return back();
  }

  public function toggle_status(Request $request, PostReport $report)
  {
    try {
       $fields = $request->validate([
            'status' => ['required', new Enum(ReportStatus::class)],
         ]);
    $report->status = ReportStatus::from($fields['status']);
    $report->save();
    // any change on status will notify user
    event(new ReportStatusUpdateEvent($report));

    return response()->json([
        'updated' => true,
        'message' => "Status {$report->status->value}"
       ]);
  } catch (\Throwable $e) {
    return response()->json([
        'updated' => false,
        'message' => $e->getMessage()
    ], 422);
}
  }

}
