<?php

namespace App\Models;

use App\Enums\ReportReason;
use App\Enums\ReportStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentReport extends Model
{
    use HasFactory;

    protected $fillable = ['reporter_id','comment_id','reason','other','status'];
    protected $casts = [
      'reason' => ReportReason::class,
      'status' => ReportStatus::class
    ];

    public function reporter()
    {
      return $this->belongsTo(User::class,'reporter_id');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }
}
