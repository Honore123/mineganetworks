<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\PurchaseOrder;
use App\Models\PurchaseProduct;
use Illuminate\Http\Request;

class PurchaseProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseOrder $order)
    {
        $data = request()->validate([
            'product_id' => ['required'],
            'quantity' => ['required'],
            'unit_price' => ['required'],
            'total_price' => ['required'],
        ]);
        $existing = PurchaseProduct::where('purchase_order_id', $order->id)->where('product_id', $data['product_id'])->first();
        if ($existing) {
            return redirect()->back()->with('error', 'Item is already on the list! You can edit it');
        }
        $data['purchase_order_id'] = $order->id;
        PurchaseProduct::create($data);

        return redirect()->back()->with('success', 'Product added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseProduct  $purchaseProduct
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseProduct  $purchaseProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseProduct $purchaseProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseProduct  $purchaseProduct
     * @return \Illuminate\Http\Response
     */
    public function update(PurchaseProduct $order)
    {
        $data = request()->validate([
            'product_id' => ['required'],
            'quantity' => ['required'],
            'unit_price' => ['required'],
            'total_price' => ['required'],
        ]);
        $existing = PurchaseProduct::whereNotIn('product_id', [$order->product->id])->where('product_id', $data['product_id'])->first();
        if ($existing) {
            return redirect()->back()->with('error', 'Item is already on the list! You can edit it and delete this one');
        }

        $order->update($data);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseProduct  $purchaseProduct
     * @return \Illuminate\Http\Response
     */
    public function delete(PurchaseProduct $order)
    {
        $order->delete();

        return redirect()->back()->with('success', 'Product removed!');
    }
}
