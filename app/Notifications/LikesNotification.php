<?php

namespace App\Notifications;



use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class LikesNotification extends Notification 
{
    use Queueable;
     

    public $user;
    public $post;
    public function __construct(User $user,Post $post)
    {
  
      $this->user = $user;
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
  
          'user_username'=>$this->user->username,
          'user_avatar'=>$this->user->avatar_url,
          'post_link'=>$this->post->slug,
          'type'=>'like',
          'message'=>"{$this->user->name} liked your post {$this->post->title}"
        ];
    }
}
