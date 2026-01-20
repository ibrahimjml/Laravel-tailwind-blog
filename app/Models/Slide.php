<?php

namespace App\Models;

use App\Enums\SlidesStatus;
use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Slide extends Model
{
    use HasFactory;
    protected $fillable = [
        'image_path',
        'title',
        'description',
        'link',
        'status',
        'published_by',
        'disabled_by',
        'published_at',
        'disabled_at',
    ];
    protected $casts = [
        'published_at' => 'datetime',
        'disabled_at' => 'datetime',
        'status' => SlidesStatus::class
    ];

    public function publishedBy()
    {
        return $this->belongsTo(User::class, 'published_by');
    }
    public function disabledBy()
    {
        return $this->belongsTo(User::class, 'disabled_by');
    }
    public function scopePublished($query)
    {
        return $query->where('status',SlidesStatus::PUBLISHED->value) ;
    }
    public function isDisabled()
    {
        return $this->status === SlidesStatus::DISABLED->value;
    }
    public function getImageAttribute()
    {
          if ($this->image_path && Storage::disk('slides')->exists($this->image_path)) {
            return Storage::disk('slides')->url($this->image_path);
          }

        if ($this->image_path && file_exists(public_path($this->image_path))) {
            return asset($this->image_path);
          }
    }
}
