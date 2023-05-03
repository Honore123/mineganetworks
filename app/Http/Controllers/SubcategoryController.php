<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;

class SubcategoryController extends Controller
{
    public function index()
    {
        return view('subcategory.index', [
            'subcategories' => Subcategory::all(),
        ]);
    }

    public function store()
    {
        $data = request()->validate(['sub_name' => ['required', 'string']]);

        Subcategory::create($data);

        return redirect()->back()->with('success', 'Sub-category added!');
    }
}
