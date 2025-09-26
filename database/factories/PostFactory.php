<?php

namespace Database\Factories;


use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        $title = $this->faker->sentence(6); 
        return [
            'title' => $this->faker->sentence(2),
            'description' => $this->faker->paragraph(20),
            'slug' => Str::slug($title),
            'image_path'=> null,
            'user_id' => null, 
        ];
    }
}

