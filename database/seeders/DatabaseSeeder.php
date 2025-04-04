<?php

namespace Database\Seeders;

use App\Models\Product;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\UserFactory;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        UserFactory::new()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        BrandFactory::new()->count(20)->create();

        CategoryFactory::new()->count(10)
            ->has(Product::factory(rand(3, 7)))
            ->create();
    }
}
