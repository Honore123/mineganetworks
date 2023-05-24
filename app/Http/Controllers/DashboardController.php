<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\PurchaseOrder;
use App\Models\Quotation;
use App\Models\Rigger;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $quotation = Quotation::where('created_at', '>', Carbon::now()->subDays(30))->count();
        $invoice = Invoice::where('created_at', '>', Carbon::now()->subDays(30))->count();
        $purchaseOrder = PurchaseOrder::where('created_at', '>', Carbon::now()->subDays(30))->count();
        $rigger = Rigger::all()->count();

        return view('dashboard.dashboard', [
            'quotation' => $quotation,
            'invoice' => $invoice,
            'purchaseOrder' => $purchaseOrder,
            'rigger' => $rigger,
        ]);
    }
}
