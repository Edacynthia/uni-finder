<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'title'       => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'price'       => $this->faker->numberBetween(1000, 100000),
            'category_id' => Category::inRandomOrder()->first()?->id ?? 1,
            'marketer_id' => User::role('marketer')->inRandomOrder()->first()?->id ?? 1,
            'image'       => 'products/sample.jpeg',
        ];
    }
}

