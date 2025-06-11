<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Post extends Model
{
  use HasFactory,Searchable;

  protected $fillable = [
    'title',
    'slug',
    'description',
    'user_id',
    'image_path',
    'is_featured',
    'likes_count',
    'views',
    'allow_comments'
  ];

  public function user()
  {  
    return $this->belongsTo(User::class, 'user_id');
  }

  public function likes(){
    return $this->hasMany(Like::class);
  }
  public function hashtags(){
    return $this->belongsToMany(Hashtag::class,'post_hashtag');
  }
  public function views()
  {
    return $this->hasMany(ProfileView::class);
  }
  public function viewers()
  {
    return $this->belongsToMany(User::class,'post_views','post_id','viewer_id');
  }
  public function toSearchableArray()
  {
    return [
      'id' =>$this->id,
      'title'=>$this->title,
      'description'=>$this->description,
      'hashtags' => $this->hashtags->pluck('name')->implode(' '),
    ];
  }

  public function is_liked(){
    return $this->likes()->where('user_id',auth()->user()->id)->exists();
  }

  public function scopeFeatured($query)
  {
    return  $query->where('is_featured', true);
  }

  public function comments(){
    return $this->hasMany(Comment::class)
    ->whereNull('parent_id')
    ->with([
        'user',
        'replies.user',
        'replies.parent.user', 
        'replies.replies.user',
        'replies.replies.parent.user',
        'replies.replies.replies.user',
        'replies.replies.replies.parent.user',
    ])
    ->orderBy('created_at','DESC');
  }
  
  public function totalcomments(){
    return $this->hasMany(Comment::class, 'post_id');
  }


  public function scopeSearch($query, $search)
  {
      if (isset($search['search'])) {
          $query->where(function ($q) use ($search) {
              $q->where('title', 'like', '%' . $search['search'] . '%')
                ->orWhere('description', 'like', '%' . $search['search'] . '%')
                ->orWhereHas('hashtags', function ($q2) use ($search) {
                    $q2->where('name', 'like', '%' . $search['search'] . '%');
                });
          });
      }
  }
  

}
