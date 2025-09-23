<?php

namespace App\Models;

use App\Enums\ReportReason;
use App\Enums\ReportStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileReport extends Model
{
    use HasFactory;
    protected $fillable = ['reporter_id','profile_id','reason','other','status'];
    protected $casts = [
      'reason' => ReportReason::class,
      'status' => ReportStatus::class
    ];

    public function user()
    {
      return $this->belongsTo(User::class,'reporter_id');
    }

    public function profile()
    {
        return $this->belongsTo(User::class, 'profile_id');
    }
}
