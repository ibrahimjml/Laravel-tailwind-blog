<?php

namespace App\Notifications;

use App\Enums\NotificationType;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class FollowersNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $follower;
    public function __construct(User $user,User $follower)
    {
        $this->user = $user;
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
  
      $message = $notifiable->is_admin
      ? "{$this->follower->name} has followed {$this->user->name}"
      : "{$this->follower->name} has followed you!";

      return [
        'user_name' => $this->user->name,
        'follower_id' => $this->follower->id,
        'follower_name' => $this->follower->name,
        'follower_username' => $this->follower->username,
        'type'=> NotificationType::FOLLOW->value,
        'message' => $message,
        
    ];
    }
}
