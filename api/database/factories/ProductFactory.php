<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'price' => fake()->numberBetween(10000, 100000),
            'image' => 'uploads/products/dummy.jpg',
            'category_id' => Category::factory()->create()->id,
            'modified_by' => User::factory()->create()->email,
            'expired_at' => now()->addDays(30),
        ];
    }
}
