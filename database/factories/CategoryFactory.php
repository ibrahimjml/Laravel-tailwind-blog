<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
  protected $model = \App\Models\Category::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'is_featured' => false,
        ];
    }
}
