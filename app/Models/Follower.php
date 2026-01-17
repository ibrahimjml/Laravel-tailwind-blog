<?php

namespace App\Models;

use App\Enums\FollowerStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','follower_id','status'];
    protected $casts = ['status' => FollowerStatus::class];
}
