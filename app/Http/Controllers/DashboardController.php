<?php

namespace App\Http\Controllers;

use App\Models\CustomerPurchaseOrder;
use App\Models\Invoice;
use App\Models\Project;
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
        $startDate = request('start');
        $endDate = request('end');
        if (! request()->filled(['start', 'end'])) {
            $currentYear = Carbon::now()->year;
            $startDate = Carbon::create($currentYear, 1, 1)->startOfDay()->toDateTime();
            $endDate = Carbon::create($currentYear, 12, 31)->startOfDay()->toDateTime();
        }
        $quotation = Quotation::whereBetween('created_at', [$startDate, $endDate])->count();
        $invoice = Invoice::whereBetween('created_at', [$startDate, $endDate])->count();
        $purchaseOrder = PurchaseOrder::whereBetween('created_at', [$startDate, $endDate])->count();
        $customerPO = CustomerPurchaseOrder::whereBetween('po_date', [$startDate, $endDate])->count();
        $rigger = Rigger::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalPOAmount = CustomerPurchaseOrder::whereBetween('po_date', [$startDate, $endDate])->where('status', '!=', '0')->sum('total_amount');
        $invoicedPOAmount = DB::table('invoice_items')
                            ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
                            ->join('customer_purchase_orders', 'invoices.customer_purchase_order_id', '=', 'customer_purchase_orders.id')
                            ->select(DB::raw('sum(total_price) as total_invoiced'))
                            ->whereBetween('customer_purchase_orders.po_date', [$startDate, $endDate])
                            ->where('invoices.status', '1')
                            ->where('invoices.customer_purchase_order_id', '!=', '0')
                            ->get();
        $contractBasedInvoice = DB::table('invoice_items')
        ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
        ->select(DB::raw('sum(total_price) as total_invoiced'))
        ->whereBetween('invoices.created_at', [$startDate, $endDate])
        ->where('invoices.status', '1')
        ->where('invoices.invoice_type', '2')
        ->get();
        $contractBasedPaidInvoice = DB::table('invoice_items')
        ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
        ->select(DB::raw('sum(total_price) as total_invoiced'))
        ->whereBetween('invoices.created_at', [$startDate, $endDate])
        ->where('invoices.status', '2')
        ->where('invoices.invoice_type', '2')
        ->get();
        $invoicedAmount = $invoicedPOAmount[0]->total_invoiced + ($invoicedPOAmount[0]->total_invoiced * 0.18);
        $contractPaidAmount = $contractBasedPaidInvoice[0]->total_invoiced + ($contractBasedPaidInvoice[0]->total_invoiced * 0.18);
        $contractUnpaidAmount = $contractBasedInvoice[0]->total_invoiced + ($contractBasedInvoice[0]->total_invoiced * 0.18);
        $unpaidPOAmount = CustomerPurchaseOrder::whereBetween('po_date', [$startDate, $endDate])->where('status', '2')->orWhere('status', '1')->sum('remaining_amount');
        $paidPOAmount = $totalPOAmount - ($unpaidPOAmount + $invoicedAmount) + $contractPaidAmount;

        $chartProjects = DB::table('projects')
        ->selectRaw('company_name, COUNT(project_code) as total_projects')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->where('deleted_at', '=', null)
        ->groupBy('company_name')
        ->get();
        $chartQuotations = DB::table('quotations')
        ->selectRaw('client_name, COUNT(quotation_code) as total_quotations')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->where('deleted_at', '=', null)
        ->groupBy('client_name')
        ->get();
        $chartInvoices = DB::table('invoices')
        ->selectRaw('company_name, COUNT(invoice_code) as total_invoices')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->where('deleted_at', '=', null)
        ->groupBy('company_name')
        ->get();
        $chartPOs = DB::table('customer_purchase_orders')
        ->selectRaw('company_name, COUNT(po_number) as total_po')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->where('deleted_at', '=', null)
        ->groupBy('company_name')
        ->get();

        // if (request()->ajax()) {
        //     return response()->json(
        //         ['total_po_amount' =>  ($totalPOAmount + $contractPaidAmount + $contractUnpaidAmount),
        //             'total_invoiced_amount' => $invoicedAmount,
        //             'contact_unpaid_invoice' => $contractUnpaidAmount,
        //             'total_paid_amount' => $paidPOAmount,
        //             'total_unpaid_amount' => $unpaidPOAmount, ]
        //     );
        // }

        return view('dashboard.dashboard', [
            'quotation' => $quotation,
            'invoice' => $invoice,
            'purchaseOrder' => $purchaseOrder,
            'customerPO' =>$customerPO,
            'rigger' => $rigger,
            'contact_unpaid_invoice' => $contractUnpaidAmount,
            'total_po_amount' => ($totalPOAmount + $contractPaidAmount + $contractUnpaidAmount),
            'total_invoiced_amount' => $invoicedAmount,
            'total_paid_amount' => $paidPOAmount,
            'total_unpaid_amount' => $unpaidPOAmount,
            'chart_projects' => $chartProjects,
            'chart_quotations' => $chartQuotations,
            'chart_invoices' => $chartInvoices,
            'chart_po' => $chartPOs,
            'start_date' => Carbon::create($startDate),
            'end_date'=> Carbon::create($endDate),
            'cashflow_chart'=>response()->json(
                ['total_po_amount' =>  ($totalPOAmount + $contractPaidAmount + $contractUnpaidAmount),
                    'total_invoiced_amount' => $invoicedAmount,
                    'contact_unpaid_invoice' => $contractUnpaidAmount,
                    'total_paid_amount' => $paidPOAmount,
                    'total_unpaid_amount' => $unpaidPOAmount, ]
            ),
        ]);
    }
}
