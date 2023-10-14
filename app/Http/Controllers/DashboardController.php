<?php

namespace App\Http\Controllers;

use App\Models\CustomerPurchaseOrder;
use App\Models\Invoice;
use App\Models\PurchaseOrder;
use App\Models\Quotation;
use App\Models\Rigger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $quotation = Quotation::all()->count();
        $invoice = Invoice::all()->count();
        $purchaseOrder = PurchaseOrder::all()->count();
        $rigger = Rigger::all()->count();
        $totalPOAmount = CustomerPurchaseOrder::where('status', '!=', '0')->sum('total_amount');
        $invoicedPOAmount = DB::table('invoice_items')
                            ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
                            ->select(DB::raw('sum(total_price) as total_invoiced'))
                            ->where('invoices.status', '1')
                            ->where('invoices.customer_purchase_order_id', '!=', '0')
                            ->get();
        $contractBasedInvoice = DB::table('invoice_items')
        ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
        ->select(DB::raw('sum(total_price) as total_invoiced'))
        ->where('invoices.status', '1')
        ->where('invoices.invoice_type', '2')
        ->get();
        $contractBasedPaidInvoice = DB::table('invoice_items')
        ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
        ->select(DB::raw('sum(total_price) as total_invoiced'))
        ->where('invoices.status', '2')
        ->where('invoices.invoice_type', '2')
        ->get();
        $invoicedAmount = $invoicedPOAmount[0]->total_invoiced + ($invoicedPOAmount[0]->total_invoiced * 0.18);
        $contractPaidAmount = $contractBasedPaidInvoice[0]->total_invoiced + ($contractBasedPaidInvoice[0]->total_invoiced * 0.18);
        $contractUnpaidAmount = $contractBasedInvoice[0]->total_invoiced + ($contractBasedInvoice[0]->total_invoiced * 0.18);
        $unpaidPOAmount = CustomerPurchaseOrder::where('status', '2')->orWhere('status', '1')->sum('remaining_amount');
        $paidPOAmount = $totalPOAmount - ($unpaidPOAmount + $invoicedAmount) + $contractPaidAmount;

        if (request()->ajax()) {
            return response()->json(
                ['total_po_amount' =>  ($totalPOAmount + $contractPaidAmount + $contractUnpaidAmount),
                    'total_invoiced_amount' => $invoicedAmount,
                    'contact_unpaid_invoice' => $contractUnpaidAmount,
                    'total_paid_amount' => $paidPOAmount,
                    'total_unpaid_amount' => $unpaidPOAmount, ]
            );
        }

        return view('dashboard.dashboard', [
            'quotation' => $quotation,
            'invoice' => $invoice,
            'purchaseOrder' => $purchaseOrder,
            'rigger' => $rigger,
            'contact_unpaid_invoice' => $contractUnpaidAmount,
            'total_po_amount' => ($totalPOAmount + $contractPaidAmount + $contractUnpaidAmount),
            'total_invoiced_amount' => $invoicedAmount,
            'total_paid_amount' => $paidPOAmount,
            'total_unpaid_amount' => $unpaidPOAmount,
        ]);
    }
}
