<?php

namespace App\Models;

use App\Enums\NotificationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNotificationSetting extends Model
{
    use HasFactory;
    protected $table = 'admin_notification_settings';
    protected $fillable = ['user_id', 'type', 'is_enabled'];
    protected $casts = [
        'type' => NotificationType::class,
        'user_id' => 'integer',
        'is_enabled' => 'boolean'
    ];
    public function user()
    {
        return $this->belongsTo(User::class)
                    ->where('is_admin', true);
    }
        
}
