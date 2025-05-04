<?php

namespace App\Listeners;

use App\Events\NewRegistered;
use App\Models\User;
use App\Notifications\NewRegisteredNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAdminNewUser
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
    public function handle(NewRegistered $event): void
    {
        $admin = User::where('is_admin',true)->first();
        if($admin){
          $admin->notify(new NewRegisteredNotification($event->user));
        }
    }
}
