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
    'image_path'
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


  public function toSearchableArray()
  {
    return [
      'title'=>$this->title,
      'description'=>$this->description,
    ];
  }

  public function is_liked(){
    return $this->likes()->where('user_id',auth()->user()->id)->exists();
  }

  public function comments(){
    return $this->hasMany(Comment::class);
  }
}
