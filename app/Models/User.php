<?php

namespace App\Models;

use App\Builders\UserBuilder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\HasPermissionsTrait;
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasPermissionsTrait;

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
      'cover_photo',
      'github',
      'linkedin',
      'twitter',
      'is_blocked',
      'aboutme',
      'username_changed_at'
  ];

    public function newEloquentBuilder($query): UserBuilder
    {
        return new UserBuilder($query);
    }
  public function post(){
    return $this->hasMany(Post::class)->published();
  }
  
   public function identityVerification()
    {
        return $this->hasOne(IdentityVerification::class);
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
  public function reportsReceived()
  {
    return $this->hasMany(ProfileReport::class, 'profile_id');
  }
  public function reportsSubmitted()
  {
    return $this->hasMany(ProfileReport::class, 'reporter_id');
  }
  public function socialLinks()
  {
    return $this->hasMany(SocialLink::class);
  }

public function getAvatarUrlAttribute()
{
    return $this->avatar !== "default.jpg" 
        ? Storage::url('avatars/'.$this->avatar) 
        : asset('storage/avatars/'.$this->avatar);
}
public function getCoverAttribute()
{
  return $this->cover_photo === 'sunset.jpg'
        ? asset('storage/covers/'.$this->cover_photo) 
        : Storage::url('covers/' . $this->cover_photo);
}
    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'username_changed_at' => 'datetime'
    ];
}
