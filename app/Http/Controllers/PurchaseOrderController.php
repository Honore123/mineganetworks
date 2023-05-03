<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\PurchaseOrder;
use App\Models\PurchaseProduct;
use App\Models\Vendor;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::query()->with('vendor')->get();
        if (request()->ajax()) {
            return datatables($purchaseOrders)
                ->editColumn('option', 'purchase-order.partials.action')
                ->editColumn('date', function ($purchaseOrder) {
                    return $purchaseOrder->created_at->format('d-m-Y');
                })
                ->editColumn('po_code', function ($purchaseOrder) {
                    return 'P'.$purchaseOrder->po_code;
                })
                ->rawColumns(['option'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('purchase-order.index');
    }

    public function add()
    {
        return view('purchase-order.add', [
            'vendors' => Vendor::all(),
        ]);
    }

    public function items(PurchaseOrder $order)
    {
        $items = PurchaseProduct::query()->where('purchase_order_id', $order->id)->with(['purchase', 'product'])->get();
        $data['total'] = $items->sum('total_price');
        $data['vat'] = $data['total'] * 0.18;
        $data['totalVat'] = $data['total'] + $data['vat'];
        $data['products'] = Products::all();

        return view('purchase-order.add-item', [
            'purchaseOrder' => $order,
            'items' => $items,
            'total' => number_format($data['total'], 0, '.', ','),
            'vat' => number_format($data['vat'], 0, '.', ','),
            'totalVat' => number_format($data['totalVat'], 0, '.', ','),
            'products' => $data['products'],
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'vendor_id' => ['required', 'integer'],
        ]);
        $latest = PurchaseOrder::where('vendor_id', $data['vendor_id'])->latest()->first();
        if ($latest) {
            $id = $latest->po_code;
            $increment = 1;
            $data['po_code'] = str_pad((intval($id) + $increment), strlen($id), '0', STR_PAD_LEFT);
        } else {
            $data['po_code'] = '00001';
        }

        $purchaseOrder = PurchaseOrder::create($data);

        return redirect()->route('purchase-order.items', $purchaseOrder->id)->with('success', 'Purchase order created! Now you can start adding items');
    }

    public function delete(PurchaseOrder $order)
    {
        $order->delete();

        return redirect()->route('purchase-order.index')->with('success', 'Purchase order deleted!');
    }
}
