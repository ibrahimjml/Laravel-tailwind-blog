<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActiveSession extends Model
{
    protected $fillable = [
        'user_id', 'session_id', 'browser_token', 'ip_address', 'user_agent', 'browser', 'platform', 'last_active_at', 'logged_out_at',
    ];

    protected $hidden = ['browser_token', 'user_agent'];

    protected $casts = [
        'last_active_at' => 'datetime',
        'logged_out_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNull('logged_out_at');
    }
}
