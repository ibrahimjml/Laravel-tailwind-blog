<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable =[
     'user_id','post_id','parent_id','content','replies_count'
    ];

    public function post(){
      return $this->belongsTo(Post::class)->published();
    }

    public function user(){
      return $this->belongsTo(User::class);
    }

    public function parent(){
      return $this->belongsTo(Comment::class,'parent_id');
    }

    public function replies(){
      return $this->hasMany(Comment::class, 'parent_id')
                  ->with(['user.roles', 'parent.user'])
                  ->orderBy('created_at','desc');
    }
  public function scopeWithNestedReplies($query, $depth = 3)
{
    if ($depth <= 0) return $query;

    return $query->with([
        'user.roles:id,name',
        'parent.user:id,name,username,avatar',
        'replies' => function ($query) use ($depth) {
            $query->withNestedReplies($depth - 1);
        }
    ])->withCount('replies');
}

    public function reports()
    {
      return $this->hasMany(CommentReport::class);
    }
}
