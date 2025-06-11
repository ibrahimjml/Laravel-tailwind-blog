<?php

namespace App\Services\Admin;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class DashboardStatsService
{
    public function getStats($year)
    {
        $registeredusers = User::select(DB::raw('COUNT(*) as count'), DB::raw('MONTHNAME(created_at) as month'))
                            ->whereYear('created_at', $year)
                            ->groupBy(DB::raw('MONTH(created_at)'), DB::raw('MONTHNAME(created_at)'))
                            ->pluck('count', 'month')
                            ->toArray();
    $numberofposts = Post::select(DB::raw('COUNT(*) as count'), DB::raw('MONTHNAME(created_at) as month'))
                            ->whereYear('created_at', $year)
                            ->groupBy(DB::raw('MONTH(created_at)'), DB::raw('MONTHNAME(created_at)'))
                            ->pluck('count', 'month')
                            ->toArray();     
        return [
          'registeredusers'=>$registeredusers,
          'numberofposts'=> $numberofposts
        ];
    }
}
