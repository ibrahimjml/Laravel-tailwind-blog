<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TwoFactorTrustedDevices extends Model
{
  use HasFactory;
  protected $fillable = [
    'user_id',
    'token_hash',
    'device_name',
    'user_agent',
    'ip',
    'last_used_at',
    'expires_at',
  ];

  protected $casts = [
    'last_used_at' => 'datetime',
    'expires_at' => 'datetime',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

}
