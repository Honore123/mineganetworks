<?php

namespace App\Http\Controllers;

use App\Models\CustomerPurchaseOrder;
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
                        return '<span class="badge bg-primary text-white w-100">Invoiced</span>';
                    } elseif ($purchaseOrder->status == '3') {
                        return '<span class="badge bg-success text-white w-100">Completed</span>';
                    } else {
                        return '<span class="badge bg-danger text-white w-100">Canceled</span>';
                    }
                })
                ->editColumn('created_at', function ($purchaseOrder) {
                    return $purchaseOrder->created_at->format('d-m-Y');
                })
                ->editColumn('total_amount', function ($purchaseOrder) {
                    return number_format($purchaseOrder->total_amount, 0, '.', ',').' Rwf';
                })
                ->editColumn('option', 'customer_po.partials.action')
                ->rawColumns(['option', 'status'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('customer_po.index', [
            'purchaseOrders' => $customersPo,
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
            'company_name' => ['required'],
            'project_title' => ['required'],
            'total_amount' => ['required'],
        ]);
        $file = request()->file('file');

        if (! $file) {
            return redirect()->back()->with('error', 'Please add a P.O file');
        }
        $data['po_document'] = uniqid().'_'.trim($file->getClientOriginalName());
        $file->storeAs('customer_POs/', $data['po_document'], 'public');
        $data['status'] = 1;
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
            'company_name' => ['required'],
            'project_title' => ['required'],
            'total_amount' => ['required'],
        ]);
        $file = request()->file('file');

        if ($file) {
            $data['po_document'] = uniqid().'_'.trim($file->getClientOriginalName());
            $file->storeAs('customer_POs/', $data['po_document'], 'public');
        }

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
