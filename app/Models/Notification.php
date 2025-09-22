<?php

namespace App\Models;

use App\Enums\NotificationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    use HasFactory;
    protected $casts = [
        'data' => 'array', 
    ];

    public function getNotificationTypeAttribute(): ?NotificationType
    {
        $type = $this->data['type'] ?? null;
        return  NotificationType::from($type) ?? null;
    }
}
