<?php

namespace App\Mail;


use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailComment extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $postowner;
    public $commenter;
    public $post;
    public function __construct(User $postowner,User $commenter,Post $post)
    {
        $this->postowner = $postowner;
        $this->commenter = $commenter;
        $this->post = $post;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email Comment',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'email.notify-comment',
            with:[
              'postowner'=>$this->postowner,
              'commenter'=>$this->commenter,
              'post'=>$this->post
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
