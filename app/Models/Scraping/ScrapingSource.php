<?php

namespace App\Models\Scraping;

use App\Enums\ScrapingType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class ScrapingSource extends Model
{
    use HasFactory;
     protected $fillable = [
        'name',
        'url',
        'type',
        'favicon_url',
        'max_age_hours',
        'max_links',
        'skip_no_image',
        'skip_no_category',
        'is_active',
        'last_run_at',
    ];
 
    protected $casts = [
        'type' => ScrapingType::class,
        'skip_no_image' => 'boolean',
        'skip_no_category' => 'boolean',
        'is_active' => 'boolean',
        'max_age_hours' => 'integer',
        'max_links' => 'integer',
        'last_run_at' => 'datetime',
    ];

    public function scrapedData(): HasMany
    {
        return $this->hasMany(ScrapedPost::class);
    }
 
    public function scrapingLogs(): HasMany
    {
        return $this->hasMany(ScrapingLog::class);
    }
 
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    protected static function booted()
    {
      $clearCaches = fn() => Cache::forget('latest-sources');
      static::created($clearCaches);
      static::updated($clearCaches);
      static::deleted($clearCaches);
    }
}
