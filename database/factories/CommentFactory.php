<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->paragraph,
            'user_id' => null,
            'post_id' => null,
            'parent_id' => null,
        ];
    }
    public function reply(int $parentId = 1)
    {
        return $this->state(fn (array $attributes) => [
               'parent_id' => $parentId,
        ]);
    }
}
