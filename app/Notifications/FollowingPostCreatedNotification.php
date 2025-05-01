<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FollowingPostCreatedNotification extends Notification
{
    use Queueable;

    public $follower;
    public $PostedBy;
    public $post;
    public function __construct(User $follower,User $PostedBy,Post $post)
    {
        $this->follower = $follower;
        $this->PostedBy = $PostedBy;
        $this->post = $post;
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
    public function toDatabase(object $notifiable): array
    {
        return [
            'postedby_id' => $this->PostedBy->id,
            'postedby_username' => $this->PostedBy->username,
            'postedby_avatar' => $this->PostedBy->avatar_url,
            'post_id' => $this->post->id,
            'post_link' => $this->post->slug,
            'message' => "{$this->PostedBy->name} created new post {$this->post->title}",
            'type' => 'Postcreated',
        ];
    }
}
