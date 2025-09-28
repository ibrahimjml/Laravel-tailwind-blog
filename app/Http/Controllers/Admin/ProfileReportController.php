<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ReportStatus;
use App\Http\Controllers\Controller;
use App\Models\ProfileReport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class ProfileReportController extends Controller
{
        public function __construct()
{
    $this->middleware('permission:profilereport.view')->only('reports');
    $this->middleware('permission:profilereport.delete')->only('delete');
    $this->middleware('permission:profilereport.status')->only('status');
  
}
    public function reports(Request $request)
    {
          $sort = $request->get('sort'); 
          $reports = ProfileReport::with(['user','profile'])
                 ->when($sort, fn($q) => $q->where('status', $sort))
                 ->latest()
                 ->paginate(10);
      return view('admin.reports.profile-reports',['reports'=>$reports]);
    }

      public function delete(ProfileReport $report)
      {
        $report->delete();
        toastr()->success('report deleted',['timeOut'=> 1000]);
        return back();
      }

  public function status(Request $request, ProfileReport $report)
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
