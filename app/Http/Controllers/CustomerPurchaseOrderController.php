<?php

namespace App\Http\Controllers;

use App\Models\CustomerPurchaseOrder;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerPurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customersPo = CustomerPurchaseOrder::orderBy('created_at', 'DESC')->get();

        if (request()->ajax()) {
            return datatables($customersPo)
                ->editColumn('status', function ($purchaseOrder) {
                    if ($purchaseOrder->status == '1') {
                        return '<span class="badge bg-warning w-100">Pending</span>';
                    } elseif ($purchaseOrder->status == '2') {
                        return '<span class="badge bg-primary text-white w-100">In progress</span>';
                    } elseif ($purchaseOrder->status == '3') {
                        return '<span class="badge bg-success text-white w-100">Completed</span>';
                    } else {
                        return '<span class="badge bg-danger text-white w-100">Canceled</span>';
                    }
                })
                ->editColumn('created_at', function ($purchaseOrder) {
                    if ($purchaseOrder->po_date == '0000-00-00 00:00:00') {
                        return 'No date';
                    }
                    $po_date = strtotime($purchaseOrder->po_date);

                    return date('d-m-Y', $po_date);
                })
                ->editColumn('total_amount', function ($purchaseOrder) {
                    return number_format((float) $purchaseOrder->total_amount, 2, '.', ',');
                })
                ->editColumn('remaining_amount', function ($purchaseOrder) {
                    return number_format((float) $purchaseOrder->remaining_amount, 2, '.', ',');
                })
                ->editColumn('option', 'customer_po.partials.action')
                ->rawColumns(['option', 'status'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('customer_po.index', [
            'purchaseOrders' => $customersPo,
            'projects' => Project::all(),
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'po_number' => ['required', 'unique:customer_purchase_orders'],
            'project_id' => ['required'],
            'total_amount' => ['required'],
            'po_date' => ['required'],
        ], [
            'project_id' => 'Project name required',
            'project_id.unique' =>'Project name already used',
        ]);
        $file = request()->file('file');
        $project = Project::where('id', $data['project_id'])->first();
        if (! $project) {
            return redirect()->back()->with('error', 'Project name not found');
        }
        if (! $file) {
            return redirect()->back()->with('error', 'Please add a P.O file');
        }
        $data['company_name'] = $project->company_name;
        $data['project_title'] = $project->project_name;
        $data['po_document'] = uniqid().'_'.trim($file->getClientOriginalName());
        $file->storeAs('customer_POs/', $data['po_document'], 'public');
        $data['status'] = 1;
        $data['remaining_amount'] = $data['total_amount'];
        CustomerPurchaseOrder::create($data);

        return redirect()->back()->with('success', 'PO added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomerPurchaseOrder  $customerPurchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerPurchaseOrder $customerPurchaseOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerPurchaseOrder  $customerPurchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerPurchaseOrder $customerPurchaseOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomerPurchaseOrder  $customerPurchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerPurchaseOrder $customerPurchaseOrder)
    {
        $data = request()->validate([
            'po_number' => ['required', Rule::unique('customer_purchase_orders')->ignore($customerPurchaseOrder->id)],
            'project_id' => ['required'],
            'total_amount' => ['required'],
            'po_date' => ['required'],
        ], ['project_id' => 'Project name required', 'project_id.unique' =>'Project name already used']);
        $file = request()->file('file');
        $project = Project::where('id', $data['project_id'])->first();
        if (! $project) {
            return redirect()->back()->with('error', 'Project name not found');
        }
        if ($file) {
            $data['po_document'] = uniqid().'_'.trim($file->getClientOriginalName());
            $file->storeAs('customer_POs/', $data['po_document'], 'public');
        }
        $invoices = Invoice::where('customer_purchase_order_id', $customerPurchaseOrder->id)->get();
        $data['remaining_amount'] = $data['total_amount'];
        if ($invoices) {
            foreach ($invoices as $invoice) {
                $invoiceItemsTotal = InvoiceItem::where('invoice_id', $invoice->id)->get()->sum('total_price');
                $data['remaining_amount'] -= ($invoiceItemsTotal + ($invoiceItemsTotal * 0.18));
            }
        }
        $data['company_name'] = $project->company_name;
        $data['project_title'] = $project->project_name;
        $customerPurchaseOrder->update($data);

        return redirect()->back()->with('success', 'PO updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerPurchaseOrder  $customerPurchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerPurchaseOrder $customerPurchaseOrder)
    {
        $customerPurchaseOrder->delete();

        return redirect()->back()->with('success', 'Customer Purchase Order deleted');
    }
}
