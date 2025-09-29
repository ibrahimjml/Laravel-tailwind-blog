<?php

namespace App\Models;

use App\Builders\CategoryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name','is_featured'];
    protected $casts=[
        'is_featured'=>'boolean',
    ];
    public function newEloquentBuilder($query)
    {
        return new CategoryBuilder($query);
    }
    public function posts()
    {
      return $this->belongsToMany(Post::class,'post_category')->published();
    }
    public function allPosts()
    {
      return $this->belongsToMany(Post::class,'post_category');
    }
}
