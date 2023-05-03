<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PricingBook;
use App\Models\Products;
use App\Models\Quotation;
use App\Models\QuotationProduct;

class QuotationProductController extends Controller
{
    public function source($client)
    {
        $data['products'] = Products::all();
        if ($client != 0) {
            $data['products'] = PricingBook::where('customer_id', $client)->with(['product'])->get();
        }
        echo json_encode($data['products']);
    }

    public function store(Quotation $quotation)
    {
        $data = request()->validate([
            'quantity' => ['required'],
            'product_id' => ['required'],
        ]);
        $source = request()->input('item_source');
        if ($quotation->client_id != 0 && $source != 0) {
            $product = PricingBook::where('customer_id', $quotation->client_id)->where('product_id', $data['product_id'])->first();
            $data['unit_price'] = $product->unit_price;
        } else {
            $product = Products::where('id', $data['product_id'])->first();
            $data['unit_price'] = $product->product_unit_price;
        }

        $data['total_price'] = $data['unit_price'] * $data['quantity'];
        $data['quotation_id'] = $quotation->id;
        QuotationProduct::create($data);

        return redirect()->back();
    }

    public function update(QuotationProduct $quotation)
    {
        $data = request()->validate([
            'quantity' => ['required'],
            'product_id' => ['required'],
        ]);
        $product = Products::where('id', $data['product_id'])->first();
        $data['unit_price'] = $product->product_unit_price;
        $data['total_price'] = $data['unit_price'] * $data['quantity'];
        $quotation->update($data);

        return redirect()->back();
    }

    public function delete(QuotationProduct $quotation)
    {
        $quotation->delete();

        return redirect()->back();
    }
}
