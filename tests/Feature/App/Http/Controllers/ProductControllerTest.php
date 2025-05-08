<?php


namespace App\Http\Controllers;

use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function itSuccessResponse(): void
    {
        $product = ProductFactory::new()->createOne();
        $response = $this->get(action(ProductController::class, [$product]));

        $response->assertOk();
        $response->assertViewIs('product.show');
        $response->assertSee($product->title);
    }
}
