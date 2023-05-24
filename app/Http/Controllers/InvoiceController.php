<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
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
        $invoices = Invoice::all()->sortBy('created_at');
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

        return view('invoice.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('invoice.add');
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
            'company_name' => ['required', 'string'],
            'tin_number' => ['required'],
            'project_title' => ['required', 'string'],
        ]);

        $invoiceCode = [
            'table' => 'invoices',
            'field' => 'invoice_code',
            'length' => 7,
            'prefix' => 'MI',
            'reset_on_prefix_change' => true,
        ];
        $data['invoice_code'] = IdGenerator::generate($invoiceCode);

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
    public function update(Request $request, Invoice $invoice)
    {
        //
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

        return $pdf->download($invoice->invoice_code.'_invoice.pdf');

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
