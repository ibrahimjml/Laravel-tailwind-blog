<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RepliedCommentNotification extends Notification
{
    use Queueable;

    public $ParentComment;
    public $replier;
    public $post;
    public function __construct(Comment $ParentComment,User $replier,Post $post)
    {
        $this->ParentComment = $ParentComment;
        $this->replier = $replier;
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
            'replier_avatar' => $this->replier->avatar_url,
            'replier_username' => $this->replier->username,
            'post_link' => $this->post->slug,
            'message' => "{$this->replier->name} replied to your comment '{$this->ParentComment->content}'",
            'type' => 'reply'
        ];
    }
}
