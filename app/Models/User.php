<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'name',
      'username',
      'email',
      'password',
      'phone',
      'age',
      'avatar',
      'aboutme'
  ];


  public function post(){
    return $this->hasMany(Post::class);
  }


  public function likes(){
    return $this->hasMany(Like::class);
  }

  public function comments(){
    return $this->hasMany(Comment::class);
  }
  public function replies(){
    return $this->comments()->whereNotNull('parent_id');
  }
  public function followings(){
    return $this->belongsToMany(User::class,'followers','follower_id','user_id');
  }
  public function followers(){
    return $this->belongsToMany(User::class,'followers','user_id','follower_id');
  }
  public function isFollowing(User $user)
  {
      return $this->followings()->where('user_id', $user->id)->exists();
  }
  
public function scopeSearch($query,$search)
{
  if(isset($search['search'])){
    $query->where('name','like','%'.$search['search'].'%')
          ->orWhere('email','like','%'.$search['search'].'%');
  }
}
public function getAvatarUrlAttribute()
{
    return $this->avatar !== "default.jpg" 
        ? Storage::url($this->avatar) 
        : '/storage/avatars/'.$this->avatar;
}
    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
