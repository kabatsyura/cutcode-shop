<?php

namespace App\Http\Controllers;

use Domain\Catalog\ViewModels\BrandViewModel;
use Domain\Catalog\ViewModels\CategoryViewModel;
use Domain\Product\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $categories = CategoryViewModel::make()->homePage();
        $brands = BrandViewModel::make()->homePage();

        $products = Product::query()
            ->homePage()
            ->get();

        return view('index', compact(
            'categories',
            'products',
            'brands'
        ));
    }
}
