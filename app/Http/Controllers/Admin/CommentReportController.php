<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Models\CommentReport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class CommentReportController extends Controller
{
        public function __construct()
{
    $this->middleware('permission:commentreport.view')->only('comment_reports');
    $this->middleware('permission:commentreport.delete')->only('comment_report_delete');
    $this->middleware('permission:commentreport.status')->only('toggle_status');
  
}
    public function comment_reports(Request $request)
    {
          $sort = $request->get('sort'); 
          $reports = CommentReport::with(['reporter','comment'])
                 ->when($sort, fn($q) => $q->where('status', $sort))
                 ->latest()
                 ->paginate(10);
      return view('admin.reports.comment-reports',['reports'=>$reports]);
    }

      public function comment_report_delete(CommentReport $report)
      {
        $report->delete();
        toastr()->success('report deleted',['timeOut'=> 1000]);
        return back();
      }

  public function toggle_status(Request $request, CommentReport $report)
  {
    try {
       $fields = $request->validate([
            'status' => ['required', new Enum(ReportStatus::class)],
         ]);
    $report->status = ReportStatus::from($fields['status']);
    $report->save();
    // any change on status will notify user
    // event(new ReportStatusUpdateEvent($report));

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
