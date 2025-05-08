<?php

namespace Domain\Cart;

use Domain\Cart\Contracts\CartIdentityStorageContract;
use Domain\Cart\Models\Cart;
use Domain\Cart\Models\CartItem;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Support\ValueObjects\Price;

final class CartManager
{
    public function __construct(
        protected CartIdentityStorageContract $identityStorage
    ) {}

    private function storedData(string $id): array
    {
        $data = [
            'storage_id' => $id
        ];

        if (Auth::check()) {
            $data['user_id'] = Auth::id();
        }

        return $data;
    }

    private function stringedOptionValues(array $optionValues = []): string
    {
        sort($optionValues);
        return implode(';', $optionValues);
    }

    public function add(Product $product, int $quantity = 1, array $optionValues = []): Model|Builder
    {
        $cart = Cart::query()
            ->updateOrCreate(
                [
                    'storage_id' => $this->identityStorage->get()
                ],
                $this->storedData($this->identityStorage->get())
            );

        $cartItem = $cart->cartItems()->updateOrCreate(
            [
                'product_id' => $product->getKey(),
                'string_option_values' => $this->stringedOptionValues($optionValues)
            ],
            [
                'price' => $product->price,
                'quantity' => DB::raw("quantity + $quantity"),
                'string_option_values' => $this->stringedOptionValues($optionValues)
            ]
        );

        $cartItem->optionValues()->sync($optionValues);

        return $cart;
    }

    public function quantity(CartItem $item, $quantity = 1): void
    {
        $item->update([
            'quantity' => $quantity
        ]);
    }

    public function delete(CartItem $item): void
    {
        $item->delete();
    }

    public function truncate(): void
    {
        $this->get()?->delete();
    }

    public function cartItems()
    {
        return $this->get()->cartItems() ?? collect();
    }

    public function count(): int
    {
        return $this->cartItems()->sum(fn($item) => $item->quantity);
    }

    public function amount(): Price
    {
        return Price::make($this->cartItems()->sum(fn($item) => $item->amount->raw));
    }

    public function get(): Cart
    {
        return Cart::query()
            ->with('cartItems')
            ->where('storage_id', $this->identityStorage->get())
            ->when(Auth::check(), fn(Builder $query) => $query->orWhere('user_id', Auth::id()))
            ->first();
    }
}