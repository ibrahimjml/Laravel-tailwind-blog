<?php

namespace Database\Factories;


use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        $title = $this->faker->sentence(4); 
        return [
            'title' => $title,
            'description' => $this->faker->paragraph(20),
            'slug' => Str::slug($title),
            'status' => $this->faker->randomElement(\App\Enums\PostStatus::cases())->value,
            'published_at' => $this->faker->optional()->dateTimeThisMonth(),
            'banned_at' => $this->faker->optional()->dateTimeThisMonth(),
            'trashed_at' => $this->faker->optional()->dateTimeThisMonth(),
            'is_featured' => false,
            'is_pinned' => false,
            'pinned_at' => null,
            'likes_count' => 0,
            'is_reported' => false,
            'report_count' => 0,
            'views' => 0,
            'image_path'=> null,
            'user_id' => null, 
        ];
    }
    public function published()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => \App\Enums\PostStatus::PUBLISHED->value,
                'published_at' => now(),
            ];
        });
    }
    public function trashed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => \App\Enums\PostStatus::TRASHED->value,
                'trashed_at' => now(),
            ];
        });
    }
    public function banned()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => \App\Enums\PostStatus::BANNED->value,
                'banned_at' => now(),
            ];
        });
    }
}

