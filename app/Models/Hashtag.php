<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{
    use HasFactory;

    protected $fillable=['name'];

    public function posts(){
      return $this->belongsToMany(Post::class,'post_hashtag');
    }
}
