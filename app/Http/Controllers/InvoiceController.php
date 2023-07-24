<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\QuotationType;
use Barryvdh\DomPDF\Facade\Pdf;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::orderBy('created_at', 'DESC')->get();
        if (request()->ajax()) {
            return datatables($invoices)
                ->editColumn('option', 'invoice.partials.action')
                ->editColumn('date', function ($invoice) {
                    return $invoice->created_at->format('d-m-Y');
                })
                ->rawColumns(['option'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('invoice.index', [
            'invoices' => $invoices,
            'types' => QuotationType::all(),
            'customers' => Customer::all(),
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
            'customers' => Customer::all(),
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
        ]);

        $invoiceCode = [
            'table' => 'invoices',
            'field' => 'invoice_code',
            'length' => 5,
            'prefix' => ' ',
            'reset_on_prefix_change' => true,
        ];
        $data['invoice_code'] = IdGenerator::generate($invoiceCode);
        $clientId = request()->input('selected_client');
        $data['company_name'] = request()->input('company_name');
        $data['tin_number'] = request()->input('tin_number');
        $data['address'] = request()->input('address');
        $customerType = request()->input('customer_type');
        if ($customerType == 1 && ! is_null($clientId)) {
            $client = Customer::where('id', $clientId)->first();
            $data['company_name'] = $client->customer_name;
            $data['tin_number'] = $client->tin;
            $data['address'] = $client->address;
            $data['client_id'] = $clientId;
        } elseif (is_null($data['company_name']) || is_null($data['tin_number']) || is_null($data['address'])) {
            return redirect()->back()->with('error', 'Please fill form correctly');
        }
        $invoice = Invoice::create($data);

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
        ]);

        $clientId = request()->input('selected_client');
        $data['company_name'] = request()->input('company_name');
        $data['tin_number'] = request()->input('tin_number');
        $data['address'] = request()->input('address');
        $customerType = request()->input('customer_type');
        if ($customerType == 1 && ! is_null($clientId)) {
            $client = Customer::where('id', $clientId)->first();
            $data['company_name'] = $client->customer_name;
            $data['tin_number'] = $client->tin;
            $data['address'] = $client->address;
            $data['client_id'] = $clientId;
        } elseif (is_null($data['company_name']) || is_null($data['tin_number']) || is_null($data['address'])) {
            return redirect()->back()->with('error', 'Please fill form correctly');
        }
        $invoice->update($data);

        return redirect()->back()->with('success', 'Invoice updated!');
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
            'vat' => number_format($data['vat'], 0, '.', ','),
            'totalVat' => number_format($data['totalVat'], 0, '.', ','),
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
