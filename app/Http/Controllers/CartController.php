<?php

namespace App\Http\Controllers;

use Domain\Cart\Models\CartItem;
use Domain\Product\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    public function add(Product $product): RedirectResponse
    {
        flash()->info('Товар добавлен в корзину');

        return redirect()->intended(route('cart'));
    }

    public function quantity(CartItem $item): RedirectResponse
    {
        flash()->info('Количество товаров изменено ');

        return redirect()->intended(route('cart'));
    }

    public function delete(CartItem $item): RedirectResponse
    {
        flash()->info('Удалено из корзины');

        return redirect()->intended(route('cart'));
    }

    public function truncate(): RedirectResponse
    {
        flash()->info('Корзина очищена');

        return redirect()->intended(route('cart'));
    }
}