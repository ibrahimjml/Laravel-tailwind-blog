<?php

namespace App\Models\Scraping;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class ScrapedPost extends Model
{
    use HasFactory;
     protected $fillable = [
        'scraping_source_id',
        'link_hash',
        'link',
        'title',
        'description',
        'category',
        'image_url',
        'last_scraped_at'
    ];
    protected $casts =[
      'last_scraped_at' => 'datetime'
    ];
    public function source(): BelongsTo
    {
        return $this->belongsTo(ScrapingSource::class, 'scraping_source_id');
    }
    protected static function booted()
    {
      $clearCaches = fn() => Cache::forget('latest-news');
      static::created($clearCaches);
      static::updated($clearCaches);
      static::deleted($clearCaches);
    }
}
