<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostView extends Model
{
    use HasFactory;
    protected $fillable = ['viewer_id','post_id'];
    public function post()
    {
      return $this->belongsTo(Post::class);
    }
    public function viewer()
    {
      return $this->belongsTo(User::class,'viewer_id');
    }
}
