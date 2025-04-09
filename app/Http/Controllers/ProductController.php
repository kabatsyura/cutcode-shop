<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __invoke(?Product $product): View
    {
        $product->load(['optionValues.option']);
        $options = $product->optionValues->mapToGroups(fn ($item) => [$item->option->title => $item]);
        $viewedProducts = Product::query()
            ->where(function (Builder $query) use ($product) {
                $query->whereIn('id', session('also'))->where('id', '!=', $product->id);
            })
            ->get();

        session()->put('also.' . $product->id, $product->id);

        return view('product.show', [
            'product' => $product,
            'options' => $options,
            'viewedProducts' => $viewedProducts,
        ]);
    }
}
