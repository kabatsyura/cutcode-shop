<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\CartController;
use Database\Factories\ProductFactory;
use Domain\Cart\CartManager;
use Domain\Product\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    private Product $product;
    private int $productQuantity = 777;

    protected function setUp(): void
    {
        parent::setUp();

        CartManager::fake();

        $this->product = ProductFactory::new()->create();
    }

    #[Test]
    public function itCartEmpty(): void
    {
        $this->get(action([CartController::class, 'index']))
            ->assertOk()
            ->assertViewIs('cart.index')
            ->assertViewHas('items', collect());
    }

    #[Test]
    public function itCartNotEmpty(): void
    {
        cart()->add($this->product);

        $this->get(action([CartController::class, 'index']))
            ->assertOk()
            ->assertViewIs('cart.index')
            ->assertViewHas('items', cart()->items());
    }

    #[Test]
    public function itAddedSuccess(): void
    {
        $this->assertEquals(0, cart()->count());

        $this->post(action([CartController::class, 'add'], $this->product), ['quantity' => $this->productQuantity]);

        $this->assertEquals($this->productQuantity, cart()->count());
    }

    #[Test]
    public function itQuantityChanged(): void
    {
        $updatedProductQuantity = 100;

        cart()->add($this->product, $this->productQuantity);
        $this->assertEquals($this->productQuantity, cart()->count());

        $this->post(action([CartController::class, 'quantity'], cart()->items()->first()), ['quantity' => $updatedProductQuantity]);

        $this->assertEquals($updatedProductQuantity, cart()->count());
    }

    #[Test]
    public function itDeleteSuccess(): void
    {
        cart()->add($this->product, $this->productQuantity);
        $this->delete(action([CartController::class, 'delete'], cart()->items()->first()));

        $this->assertEquals(0, cart()->count());
    }

    #[Test]
    public function itTruncateSuccess(): void
    {
        cart()->add($this->product, $this->productQuantity);
        $this->delete(action([CartController::class, 'truncate']));

        $this->assertEquals(0, cart()->count());
    }
}
