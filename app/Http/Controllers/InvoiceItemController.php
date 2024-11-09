<?php

namespace App\Http\Controllers;

use App\Models\CustomerPurchaseOrder;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;

class InvoiceItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Invoice $invoice)
    {
        $customer_po = null;
        if ($invoice->invoice_type == 1) {
            if (! $invoice->customer_purchase_order_id) {
                return redirect()->back()->with('error', 'The invoice '.$invoice->invoice_code.' of '.$invoice->company_name." doesn't have a PO. Please assign a PO before adding items");
            }
            $customer_po = CustomerPurchaseOrder::where('id', $invoice->customer_purchase_order_id)->first();
        }
        $items = InvoiceItem::query()->where('invoice_id', $invoice->id)->get();
        $data['total'] = $items->sum('total_price');
        $data['vat'] = ($data['total'] * 0.18);
        $data['totalVat'] = $data['total'] + $data['vat'];

        return view('invoice.add-item', [
            'invoice' => $invoice,
            'items' => $items,
            'total' => number_format($data['total'], 0, '.', ','),
            'vat' => number_format($data['vat'], 2, '.', ','),
            'totalVat' => number_format($data['totalVat'], 2, '.', ','),
            'customer_po' => $customer_po,
        ]);
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
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Invoice $invoice)
    {
        $data = request()->validate([
            'item_name' => ['required', 'string'],
            'quantity' => ['required'],
            'unit_price' => ['required'],
            'total_price' => ['required'],
        ]);

        $data['invoice_id'] = $invoice->id;
        $customer_po = null;
        if ($invoice->invoice_type == 1) {
            $customer_po = CustomerPurchaseOrder::where('id', $invoice->customer_purchase_order_id)->first();
            if (((int) $data['total_price'] + ((int) $data['total_price'] * 0.18)) > (float) $customer_po->remaining_amount) {
                return redirect()->back()->with('error', 'Amount entered exceeds remaining amount on P.O');
            }
        } else {
            $data['rigger_days'] = request()->input('rigger_days');
        }
        InvoiceItem::create($data);
        $invoice->update([
            'updated_at' => now(),
        ]);
        if (! is_null($customer_po)) {
            $customer_po->update([
                'remaining_amount' => strval((float) $customer_po->remaining_amount - ((int) $data['total_price'] + ((int) $data['total_price'] * 0.18))),
            ]);
        }

        return redirect()->back()->with('success', 'Item added');
    }

    /**
     * Display the specified resource.
     *
     * @param  InvoiceItem  $invoiceItem
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceItem $invoiceItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  InvoiceItem  $invoiceItem
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceItem $invoiceItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  InvoiceItem  $invoiceItem
     * @return \Illuminate\Http\Response
     */
    public function update(InvoiceItem $item)
    {
        $data = request()->validate([
            'item_name' => ['required', 'string'],
            'quantity' => ['required'],
            'unit_price' => ['required'],
            'total_price' => ['required'],
        ]);
        $invoice = Invoice::where('id', $item->invoice_id)->first();
        $old_total_price = (int) $item->total_price + ((int) $item->total_price * 0.18);
        $customer_po = null;
        if ($invoice->invoice_type == 1) {
            $customer_po = CustomerPurchaseOrder::where('id', $invoice->customer_purchase_order_id)->first();

            if (((int) $data['total_price'] + ((int) $data['total_price'] * 0.18)) > ((float) $customer_po->remaining_amount + (float) $old_total_price)) {
                return redirect()->back()->with('error', 'Amount entered exceeds remaining amount on P.O');
            }
        } else {
            $data['rigger_days'] = request()->input('rigger_days');
        }
        $item->update($data);
        $invoice->update([
            'updated_at' => now(),
        ]);
        if (! is_null($customer_po)) {
            $customer_po->update([
                'remaining_amount' => strval(((float) $customer_po->remaining_amount + (float) $old_total_price) - ((int) $data['total_price'] + ((int) $data['total_price'] * 0.18))),
            ]);
        }

        return redirect()->back()->with('success', 'Item updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  InvoiceItem  $invoiceItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceItem $item)
    {
        $invoice = Invoice::where('id', $item->invoice_id)->first();
        if ($invoice->invoice_type == 1) {
            $customer_po = CustomerPurchaseOrder::where('id', $invoice->customer_purchase_order_id)->first();
            $remaining_amount = strval((float) $customer_po->remaining_amount + ((int) $item->total_price + ((int) $item->total_price * 0.18)));
            if ((float) $remaining_amount > (float) $customer_po->total_amount) {
                $remaining_amount = $customer_po->total_amount;
            }
            $customer_po->update([
                'remaining_amount' => $remaining_amount,
            ]);
        }
        $item->delete();
        $invoice->update([
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Item removed');
    }
}
