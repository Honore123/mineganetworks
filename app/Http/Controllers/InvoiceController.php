<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerPurchaseOrder;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceTypes;
use App\Models\QuotationType;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::with(['purchaseOrder'])->orderBy('created_at', 'DESC')->get();

        if (request()->ajax()) {
            function calculateTotal($invoice)
            {
                $total = DB::table('invoice_items')
                            ->select('invoice_id', DB::raw('sum(total_price) as total_amount'))
                            ->groupBy('invoice_id')
                            ->where('invoice_id', $invoice->id)
                            ->get();

                return count($total) > 0 ? intval($total[0]->total_amount) : 0;
            }

            return datatables($invoices)
                ->editColumn('option', 'invoice.partials.action')
                ->editColumn('date', function ($invoice) {
                    return $invoice->created_at->format('d-m-Y');
                })
                ->editColumn('status', function ($invoice) {
                    if ($invoice->status == '1') {
                        return '<span class="badge bg-warning w-100">Pending</span>';
                    } elseif ($invoice->status == '2') {
                        return '<span class="badge bg-success text-white w-100">Paid</span>';
                    } else {
                        return '<span class="badge bg-danger text-white w-100">Canceled</span>';
                    }
                })
                ->editColumn('total_inc_vat', function ($invoice) {
                    $total_inc_vat = (calculateTotal($invoice) * 0.18) + calculateTotal($invoice);

                    return number_format($total_inc_vat, 0, '.', ',');
                })
                ->rawColumns(['option', 'status'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('invoice.index', [
            'invoices' => $invoices,
            'types' => QuotationType::all(),
            'customers' => Customer::all(),
            'invoiceTypes' => InvoiceTypes::all(),
            'purchaseOrders' => CustomerPurchaseOrder::orderBy('created_at', 'DESC')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('invoice.add', [
            'types' => QuotationType::all(),
            'invoiceTypes' => InvoiceTypes::all(),
            'customers' => Customer::all(),
            'purchaseOrders' => CustomerPurchaseOrder::orderBy('created_at', 'DESC')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'project_title' => ['required', 'string'],
            'invoice_type' => ['required'],
        ]);

        $clientId = request()->input('selected_client');
        $data['company_name'] = request()->input('company_name');
        $data['tin_number'] = request()->input('tin_number');
        $data['address'] = request()->input('address');
        $customerType = request()->input('customer_type');
        $data['customer_purchase_order_id'] = request()->input('customer_purchase_order_id');
        $purchaseOrder = null;
        if (is_null($data['customer_purchase_order_id']) && $data['invoice_type'] == 1) {
            return redirect()->back()->with('error', 'Select P.O');
        }
        if ($data['customer_purchase_order_id'] && $data['invoice_type'] == 1) {
            $purchaseOrder = CustomerPurchaseOrder::where('id', $data['customer_purchase_order_id'])->first();
            if ((int) $purchaseOrder->remaining_amount == 0) {
                return redirect()->back()->with('error', 'Selected PO already completed. Please select pending or in progress PO');
            }
        } else {
            $data['customer_purchase_order_id'] = 0;
        }
        if ($customerType == 1 && ! is_null($clientId)) {
            $client = Customer::where('id', $clientId)->first();
            $data['company_name'] = $client->customer_name;
            $data['tin_number'] = $client->tin;
            $data['address'] = $client->address;
            $data['client_id'] = $clientId;
        } elseif (is_null($data['company_name']) || is_null($data['tin_number']) || is_null($data['address'])) {
            return redirect()->back()->with('error', 'Please fill form correctly');
        }
        $latest = Invoice::where('tin_number', $data['tin_number'])->latest()->first();
        if ($latest) {
            $id = trim($latest->invoice_code);
            $increment = 1;
            $data['invoice_code'] = str_pad((intval($id) + $increment), strlen($id), '0', STR_PAD_LEFT);
        } else {
            $data['invoice_code'] = '0001';
        }
        $invoice = Invoice::create($data);
        if (! is_null($purchaseOrder)) {
            $purchaseOrder->update(['status' => 2]);
        }

        return redirect()->route('invoiceItem.index', $invoice->id)->with('success', 'Invoice created! Now you can start adding items');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Invoice $invoice)
    {
        $data = request()->validate([
            'project_title' => ['required', 'string'],
            'invoice_type' => ['required'],
        ]);

        $clientId = request()->input('selected_client');
        $data['company_name'] = request()->input('company_name');
        $data['tin_number'] = request()->input('tin_number');
        $data['address'] = request()->input('address');
        $data['customer_purchase_order_id'] = request()->input('customer_purchase_order_id');
        $customerType = request()->input('customer_type');
        $purchaseOrder = null;
        if ($customerType == 1 && ! is_null($clientId)) {
            $client = Customer::where('id', $clientId)->first();
            $data['company_name'] = $client->customer_name;
            $data['tin_number'] = $client->tin;
            $data['address'] = $client->address;
            $data['client_id'] = $clientId;
        } elseif (is_null($data['company_name']) || is_null($data['tin_number']) || is_null($data['address'])) {
            return redirect()->back()->with('error', 'Please fill form correctly');
        }
        if ($data['customer_purchase_order_id'] && $data['invoice_type'] == 1) {
            $purchaseOrder = CustomerPurchaseOrder::where('id', $data['customer_purchase_order_id'])->first();
            if ($invoice->customer_purchase_order_id != $data['customer_purchase_order_id']) {
                $addUpBalance = InvoiceItem::where('invoice_id', $invoice->id)->sum('total_price');
                $oldPO = CustomerPurchaseOrder::where('id', $invoice->customer_purchase_order_id)->first();
                if (($addUpBalance + ($addUpBalance * 0.18)) <= $purchaseOrder->remaining_amount) {
                    $otherInvoices = Invoice::where('id', '!=', $invoice->id)->where('customer_purchase_order_id', $invoice->customer_purchase_order_id)->first();
                    $newStatus = 1;
                    if ($otherInvoices) {
                        $newStatus = 2;
                    }
                    if ($oldPO) {
                        $oldPO->update([
                            'status' => $newStatus,
                            'remaining_amount' => $oldPO->remaining_amount + ($addUpBalance + ($addUpBalance * 0.18)),
                        ]);
                    }
                } else {
                    return redirect()->back()->with('error', "The Chosen PO doesn't have enough remaining amount!");
                }
            }
        } else {
            $data['customer_purchase_order_id'] = 0;
        }
        $invoice->update($data);
        if (! is_null($purchaseOrder)) {
            $poInvoices = Invoice::where('customer_purchase_order_id', $purchaseOrder->id)->get();
            $remainingAmount = $purchaseOrder->total_amount;

            if ($poInvoices) {
                foreach ($poInvoices as $poInvoice) {
                    $invoiceItemsTotal = InvoiceItem::where('invoice_id', $poInvoice->id)->get()->sum('total_price');
                    $remainingAmount -= ($invoiceItemsTotal + ($invoiceItemsTotal * 0.18));
                }
            }

            $purchaseOrder->update(['status' => 2, 'remaining_amount' => $remainingAmount]);
        }

        return redirect()->back()->with('success', 'Invoice updated!');
    }

    public function status(Invoice $invoice)
    {
        $data = request()->validate([
            'status' => ['required'],
        ]);
        if (! $invoice->customer_purchase_order_id) {
            return redirect()->back()->with('error', 'The invoice '.$invoice->invoice_code.' of '.$invoice->company_name." doesn't have a PO");
        }
        $invoice->update($data);
        $purchaseOrder = CustomerPurchaseOrder::where('id', $invoice->customer_purchase_order_id)->first();
        if ($data['status'] == '2' && (int) $purchaseOrder->remaining_amount == 0) {
            $invoice->update($data);
            $purchaseOrder->update(['status' => 3]);
        } elseif ($data['status'] == '0') {
            $invoiceItemsTotal = InvoiceItem::where('invoice_id', $invoice->id)->get()->sum('total_price');
            $remainingAmount = $purchaseOrder->remaining_amount + ($invoiceItemsTotal + ($invoiceItemsTotal * 0.18));
            $purchaseOrder->update(['remaining_amount' => ($remainingAmount)]);
        }

        return redirect()->back()->with('success', $purchaseOrder->po_number.' invoice updated');
    }

    public function download(Invoice $invoice)
    {
        $items = InvoiceItem::where('invoice_id', $invoice->id)->get();
        $data['total'] = $items->sum('total_price');
        $data['vat'] = $data['total'] * 0.18;
        $data['totalVat'] = $data['total'] + $data['vat'];

        $pdf = Pdf::loadView('invoice.download_invoice', [
            'invoice' => $invoice,
            'items' => $items,
            'total' => number_format($data['total'], 0, '.', ','),
            'vat' => number_format($data['vat'], 2, '.', ','),
            'totalVat' => number_format($data['totalVat'], 2, '.', ','),
        ]);

        return $pdf->download($invoice->company_name.'_invoice.pdf');

        // return view('invoice.download_invoice', [
        //     'invoice' => $invoice,
        //     'items' => $items,
        //     'total' => number_format($data['total'], 0, '.', ','),
        //     'vat' => number_format($data['vat'], 0, '.', ','),
        //     'totalVat' => number_format($data['totalVat'], 0, '.', ','),
        // ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('invoice.index')->with('success', 'Invoice deleted');
    }
}
