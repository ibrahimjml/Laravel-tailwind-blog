<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class FollowersNotification extends Notification
{
    use Queueable;

    protected $follower;

  
    public function __construct($follower)
    {
        $this->follower = $follower;
    
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase( $notifiable): array
    {
    
      return [
        'follower_id' => $this->follower->id,
        'follower_name' => $this->follower->name,
        'follower_username' => $this->follower->username,
        'follower_avatar_url' => $this->follower->avatar_url,
        'type'=>'follow',
        'message' => "{$this->follower->name} has followed you!",
        
    ];
    }
}
