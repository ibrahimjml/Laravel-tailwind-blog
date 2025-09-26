<?php

namespace App\Models;

use App\Enums\TagStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{
    use HasFactory;

    protected $fillable=['name','is_featured','status'];
    protected $attributes = [
    'status' => TagStatus::ACTIVE->value, 
];
    protected $casts=[
        'is_featured'=>'boolean',
        'status'=> TagStatus::class
    ];
    public function posts(){
      return $this->belongsToMany(Post::class,'post_hashtag');
    }
    public function scopeStatus($query,$status){
         if (!$status || $status === 'all') {
              return $query;
          }
        return $query->where('status',$status);
    }
    public function scopeActive($query)
    {
      return $query->where('status',TagStatus::ACTIVE->value);
    }
}
