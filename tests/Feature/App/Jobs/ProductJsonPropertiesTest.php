<?php


namespace Tests\Feature\App\Jobs;

use App\Jobs\ProductJsonPropertiesJob;
use Database\Factories\ProductFactory;
use Database\Factories\PropertyFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProductJsonPropertiesTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function itCreateJsonProperties(): void
    {
        $queue = Queue::getFacadeRoot();
        Queue::fake([ProductJsonPropertiesJob::class]);

        $properties = PropertyFactory::new()->count(5)->create();
        $product = ProductFactory::new()
            ->hasAttached($properties, fn () => ['value' => fake()->word()])
            ->create();
        $this->assertEmpty($product->json_properties);

        $expectedPropertiesKeys = Arr::map($properties->toArray(), fn ($prop) => $prop['title']);

        Queue::swap($queue);
        ProductJsonPropertiesJob::dispatchSync($product);

        $product->refresh();
        $poductPropertiesKeys = array_keys($product->json_properties);

        $this->assertNotEmpty($product->json_properties);
        $this->assertEmpty(array_diff($expectedPropertiesKeys, $poductPropertiesKeys));
        $this->assertEmpty(array_diff($poductPropertiesKeys, $expectedPropertiesKeys));
    }
}
