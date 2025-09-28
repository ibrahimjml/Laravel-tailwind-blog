<?php

namespace App\Http\Controllers\Admin;


use App\Services\Admin\DashboardStatsService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class AdminController extends Controller
{
    public function __construct(protected DashboardStatsService $stats){
        $this->middleware('permission:Access')->only('admin');
    }
  public function admin(){
  
    $user = DB::table('users')->count();
    $post = DB::table('posts')->count();
    $likes = DB::table('likes')->count();
    $hashtags = DB::table('hashtags')->count();
    $categories = DB::table('categories')->count();
    $comments = DB::table('comments')->count();
    $blocked = DB::table('users')->where('is_blocked',1)->count();
    $postreports = DB::table('post_reports')->count();
    $profilereports = DB::table('profile_reports')->count();
    $commentreports = DB::table('comment_reports')->count();
    $year = request('year', date('Y'));

    $data = $this->stats->getStats($year);             
    return view('admin.adminpanel',compact(['user','post','likes','hashtags','categories','comments','blocked','postreports','profilereports','commentreports','data']));
  }


}
