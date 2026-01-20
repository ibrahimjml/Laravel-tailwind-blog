<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slide>
 */
class SlideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'image_path' => 'mountain.jpg',
        'title'       => fake()->sentence(),
        'description' => fake()->paragraph,    
        'link'        => fake()->url(),
        'status'      => \App\Enums\SlidesStatus::PUBLISHED->value,
        'published_by' => null,
        'disabled_by'  => null,
        'published_at' => now()->toDateString(),
        'disabled_at'  => now()->toDateString(),
        ];
    }
}
