<?php

namespace App\Http\Controllers;

use App\View\ViewModels\CatalogViewModel;
use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function __invoke(?Category $category): CatalogViewModel
    {
        return (new CatalogViewModel($category))->view('catalog.index');
    }
}
