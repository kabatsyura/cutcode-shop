<?php

namespace Database\Seeders;

use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\OptionFactory;
use Database\Factories\OptionValueFactory;
use Database\Factories\ProductFactory;
use Database\Factories\PropertyFactory;
use Database\Factories\UserFactory;
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

        $properties = PropertyFactory::new()->count(10)->create();

        OptionFactory::new()->count(2)->create();
        $optionValues = OptionValueFactory::new()->count(10)->create();

        BrandFactory::new()->count(20)->create();

        CategoryFactory::new()->count(10)
            ->has(
                ProductFactory::new()->count(rand(5, 15))
                    ->hasAttached($optionValues)
                    ->hasAttached($properties, fn () => ['value' => ucfirst(fake()->word())])
            )
            ->create();
    }
}
