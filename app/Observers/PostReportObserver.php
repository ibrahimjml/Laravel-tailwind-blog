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
        $post = $postReport->post;
        event(new PostReportEvent($post, $postReport->user,$postReport));
        $post->increment('report_count');
        // check still reports_count > 0 if true is_reported is true else false
        $post->is_reported = $post->report_count > 0;
        $post->save();

    }

  

    /**
     * Handle the PostReport "deleted" event.
     */
    public function deleted(PostReport $postReport): void
    {
        $post = $postReport->post;
        $post->decrement('report_count');
        $post->is_reported = $post->report_count > 0;
        $post->save();

        DatabaseNotification::where('type', PostReportNotification::class)
      ->whereJsonContains('data->post_id', $postReport->post->id)
      ->delete();
    }

  
}
