<?php

namespace App\Models\Scraping;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScrapingLog extends Model
{
    use HasFactory;

     protected $fillable = [
        'scraping_source_id',
        'level',
        'message',
    ];
 
    public function source(): BelongsTo
    {
        return $this->belongsTo(ScrapingSource::class, 'scraping_source_id');
    }
 
    public function scopeLevel($query, ?string $level)
    {
        return $level ? $query->where('level', $level) : $query;
    }
}
