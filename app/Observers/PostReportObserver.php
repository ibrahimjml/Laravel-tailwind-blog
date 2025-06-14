<?php

namespace App\Observers;

use App\Events\PostReportEvent;
use App\Models\PostReport;
use App\Notifications\PostReportNotification;
use Illuminate\Notifications\DatabaseNotification;

class PostReportObserver
{
    /**
     * Handle the PostReport "created" event.
     */
    public function created(PostReport $postReport): void
    {
        event(new PostReportEvent($postReport->post, $postReport->user));
        $postReport->post()->increment('report_count');
    }

  

    /**
     * Handle the PostReport "deleted" event.
     */
    public function deleted(PostReport $postReport): void
    {
        $postReport->post()->decrement('report_count');

        DatabaseNotification::where('type', PostReportNotification::class)
      ->whereJsonContains('data->post_id', $postReport->post->id)
      ->delete();
    }

  
}
