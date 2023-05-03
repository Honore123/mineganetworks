<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    public function index()
    {
        return view('category.index', [
            'categories' => ProductCategory::all(),
        ]);
    }
}
