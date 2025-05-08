<?php

namespace App\Http\Controllers;

use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __invoke(?Product $product): View
    {
        $product->load(['optionValues.option']);
        $viewedProducts = Product::query()
            ->where(function (Builder $query) use ($product) {
                if (null !== session('also')) {
                    $query
                        ->whereIn('id', session('also'))
                        ->where('id', '!=', $product->id);
                }
            })
            ->get();


        session()->put('also.' . $product->id, $product->id);

        return view('product.show', [
            'product' => $product,
            'options' => $product->optionValues->keyValues(),
            'viewedProducts' => $viewedProducts,
        ]);
    }
}
