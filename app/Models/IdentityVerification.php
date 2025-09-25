<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentityVerification extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'code',
        'expires_at',
    ];
    protected $casts = [
        'expires_at' => 'datetime',
    ];

     public function user()
    {
        return $this->belongsTo(User::class);
    }
}
