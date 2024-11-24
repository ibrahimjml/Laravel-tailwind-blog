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

class postlike extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $postowner;
    public $user;
    public $post;
    
    public function __construct(User $postowner,User $user,Post $post)
    {
        $this->postowner = $postowner;      
        $this->user = $user;
        $this->post = $post;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Postlike',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'email.postliked',
            with:[
              'postowner'=>$this->postowner,
              'user'=>$this->user,
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
