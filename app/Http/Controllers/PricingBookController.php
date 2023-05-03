<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PricingBook;
use App\Models\Products;

class PricingBookController extends Controller
{
    public function index(Customer $customer)
    {
        $products = PricingBook::query()->where('customer_id', $customer->id)
                                        ->with(['product', 'product.category', 'product.subcategory', 'product.unit'])
                                        ->get();

        if (request()->ajax()) {
            return datatables($products)
            ->editColumn('unit_price', function ($product) {
                return number_format($product->unit_price, 0, '.', ',').' Rwf';
            })
            ->editColumn('option', 'pricing-book.partials.action')
            ->rawColumns(['option'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('pricing-book.index', [
            'customer' =>$customer,
            'products' => Products::all(),
        ]);
    }

    public function store(Customer $customer)
    {
        $data = request()->validate([
            'product_id'=>['required', 'integer'],
        ]);
        $data['customer_id'] = $customer->id;
        $exist = PricingBook::where('customer_id', $data['customer_id'])->where('product_id', $data['product_id'])->first();
        if (! is_null($exist)) {
            return redirect()->back()->with('error', 'Product Already on added');
        }
        $product = Products::where('id', $data['product_id'])->first();
        $data['unit_price'] = $product->product_unit_price;

        PricingBook::create($data);

        return redirect()->back()->with('success', 'Product added');
    }

    public function delete(PricingBook $product)
    {
        $product->delete();

        return redirect()->back()->with('success', 'Product remove');
    }
}
