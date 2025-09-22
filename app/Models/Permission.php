<?php

namespace App\Models;

use App\Enums\PermissionModule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Permission extends Model
{
    use HasFactory;
     protected $fillable = ['name','slug','module','description'];
     protected $casts =[
       'module' => PermissionModule::class
     ];
      protected static function booted()
    {
        static::creating(function ($permission) {
            $permission->slug = Str::slug($permission->name);
        });
    }
     public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
   
    public function users()
    {
      return $this->belongsToMany(User::class,'permission_user');
    }
}
