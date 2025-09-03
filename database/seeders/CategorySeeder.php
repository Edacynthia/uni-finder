<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Clothing',
            'Books',
            'Food', 
            'Accessories',
            'Home & Garden',
            'Beauty',
            'Sports & Outdoors',
            'Toys & Games',
            'Gadgets',
            'Health',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category]);
        }
    }
}

