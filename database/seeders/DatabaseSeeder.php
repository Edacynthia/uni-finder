<?php

namespace Database\Seeders;

use App\Models\Category;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\PermissionSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            PermissionSeeder::class,
            CategorySeeder::class,  
        ]);
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

       
 // 2️⃣ Seed a test user
        User::firstOrCreate([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ])->assignRole('user');

        // 3️⃣ Seed 10 marketers with profiles and marketer role
        $marketers = User::factory(10)
            ->hasMarketerProfile()
            ->create()
            ->each(function ($user) {
                $user->assignRole('marketer');
            });

        // 4️⃣ Seed products evenly across categories
        $categories = Category::all();
        $totalProducts = 50;
        $perCategory = (int) ceil($totalProducts / $categories->count());

        foreach ($categories as $category) {
            Product::factory($perCategory)->create([
                'category_id' => $category->id,
                // Pick a random marketer from the seeded marketers
                'marketer_id' => $marketers->random()->id,
            ]);
        }
    }
}
