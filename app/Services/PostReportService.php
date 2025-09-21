<?php

namespace App\Services;

use App\DTOs\PostReportDTO;
use App\Enums\ReportStatus;
use App\Models\Post;
use App\Models\PostReport;

class PostReportService
{
    public function report(Post $post,PostReportDTO $dto)
    {
        $exists = PostReport::where('user_id',$dto->userId)
                 ->where('post_id',$post->id)
                 ->exists();
    if ($exists) return false;
    
     PostReport::create([
            'user_id' => $dto->userId,
            'post_id' => $post->id,
            'reason' => $dto->reason,
            'status'  => ReportStatus::Pending,
            'other' => $dto->other
        ]);
        
        return true;
    }
}
