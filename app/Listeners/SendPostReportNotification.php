<?php

namespace App\Listeners;

use App\Events\PostReportEvent;
use App\Models\User;
use App\Notifications\PostReportNotification;
use App\Notifications\ReportStatusNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPostReportNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostReportEvent $event): void
    {
        $post = $event->post;
        $reporter = $event->user;
        $report = $event->report;
        // Notify all admins
         User::where('is_admin', true)->get()->each(function ($admin) use ( $post,$reporter) {
      $admin->notify(new PostReportNotification(  $post,$reporter));
       });
      // Notify  reporter that report is pending
      $reporter->notify(new ReportStatusNotification($report));
    }
}
