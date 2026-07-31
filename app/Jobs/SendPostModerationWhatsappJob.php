<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendPostModerationWhatsappJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Create a new job instance.
   */
  public function __construct(protected Post $post)
  {
    //
  }

  /**
   * Execute the job.
   */
  public function handle(): void
  {
    $author = $this->post->user;

    if (!$author) {
      Log::error("WhatsApp Notification failed: Post ID {$this->post->id} has no valid user relation.");
      return;
    }

    $messageText = <<<TEXT
        🆕 New Post needs approval 
        
        👤 User: {$author->name}
        📝 Post Title: {$this->post->title}
        🔄 Post Status: {$this->post->status->value}
        📧 Email: {$author->email}
        📱 Phone: {$author->phone}
        TEXT;

    $webhookUrl = config('n8n.webhook_url');

    $response = Http::withHeaders([
      'Content-Type' => 'application/json',
      'Accept' => 'application/json',
    ])->post($webhookUrl, [
          'success' => true,
          'to_phone' => config('n8n.phone'),
          'message' => $messageText,

          'template' => [
            'name' => 'new_post_approval',
            'language' => [
              'code' => 'en',
            ],
          ],

          'parameters' => [
               [
                 'type' => 'text',
                 'text' => $author->name,
               ],
               [
                 'type' => 'text',
                 'text' => $this->post->title,
               ],
               [
                 'type' => 'text',
                 'text' => $this->post->status->value,
               ],
               [
                 'type' => 'text',
                 'text' => $author->email,
               ],
               [
                 'type' => 'text',
                 'text' => $author->phone,
               ],
          ],

          'button_parameters' => [
               [
                 'type' => 'text',
                 'text' => $this->post->slug,
               ],
               [
                 'type' => 'text',
                 'text' => $this->post->slug,
               ],
          ],
        ]);
    if ($response->failed()) {
      Log::error("n8n WhatsApp Webhook failure for Post ID {$this->post->id}. Status: " . $response->status() . " Body: " . $response->body());
    }
  }
}

