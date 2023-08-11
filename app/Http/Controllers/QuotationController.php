<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PricingBook;
use App\Models\Products;
use App\Models\Quotation;
use App\Models\QuotationProduct;
use App\Models\QuotationType;
use Barryvdh\DomPDF\Facade\Pdf;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    public function index()
    {
        $quotations = Quotation::orderBy('created_at', 'DESC')->get();
        if (request()->ajax()) {
            function calculateTotal($quotation)
            {
                $total = DB::table('quotation_products')
                            ->select('quotation_id', DB::raw('sum(total_price) as total_amount'))
                            ->groupBy('quotation_id')
                            ->where('quotation_id', $quotation->id)
                            ->get();

                return count($total) > 0 ? intval($total[0]->total_amount) : 0;
            }

            return datatables($quotations)
                ->editColumn('option', 'quotation.partials.action')
                ->editColumn('date', function ($quotation) {
                    return $quotation->created_at->format('d-m-Y');
                })
                ->editColumn('total_amount', function ($quotation) {
                    $total = calculateTotal($quotation);

                    return number_format($total, 0, '.', ',').' Rwf';
                })
                ->editColumn('vat', function ($quotation) {
                    $vat = calculateTotal($quotation) * 0.18;

                    return number_format($vat, 0, '.', ',').' Rwf';
                })
                ->editColumn('total_inc_vat', function ($quotation) {
                    $total_inc_vat = (calculateTotal($quotation) * 0.18) + calculateTotal($quotation);

                    return number_format($total_inc_vat, 0, '.', ',').' Rwf';
                })
                ->rawColumns(['option'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('quotation.index', [
            'quotations' => $quotations,
            'types' => QuotationType::all(),
            'customers' => Customer::all(), ]);
    }

    public function add()
    {
        return view('quotation.add', [
            'types' => QuotationType::all(),
            'customers' => Customer::all(),
        ]);
    }

    public function items(Quotation $quotation)
    {
        $items = QuotationProduct::query()->where('quotation_id', $quotation->id)->with(['quotation', 'product'])->get();
        $data['total'] = $items->sum('total_price');
        $data['vat'] = $data['total'] * 0.18;
        $data['totalVat'] = $data['total'] + $data['vat'];
        $data['products'] = Products::all();
        if ($quotation->client_id != 0) {
            $data['products'] = PricingBook::where('customer_id', $quotation->client_id)->with(['product'])->get();
        }

        return view('quotation.add-item', [
            'quotation' => $quotation,
            'items' => $items,
            'total' => number_format($data['total'], 0, '.', ','),
            'vat' => number_format($data['vat'], 0, '.', ','),
            'totalVat' => number_format($data['totalVat'], 0, '.', ','),
            'products' => $data['products'],
        ]);
    }

    public function edit(Quotation $quotation)
    {
        return view('quotation.edit');
    }

    public function downloadQuotation(Quotation $quotation)
    {
        $items = QuotationProduct::where('quotation_id', $quotation->id)->get();
        $data['total'] = $items->sum('total_price');
        $data['vat'] = $data['total'] * 0.18;
        $data['totalVat'] = $data['total'] + $data['vat'];
        $client = $quotation->client_name;
        if ($quotation->client_id != 0) {
            $client = Customer::where('id', $quotation->client_id)->first();
        }

        $pdf = Pdf::loadView('quotation.download_quotation', [
            'quotation' => $quotation,
            'items' => $items,
            'total' => number_format($data['total'], 0, '.', ','),
            'vat' => number_format($data['vat'], 0, '.', ','),
            'totalVat' => number_format($data['totalVat'], 0, '.', ','),
            'client' => $client,
        ]);

        return $pdf->download($quotation->project_title.'_quotation.pdf');
        // return view('quotation.download_quotation', [
        //     'quotation' => $quotation,
        //     'items' => $items,
        //     'total' => number_format($data['total'], 0, '.', ','),
        //     'vat' => number_format($data['vat'], 0, '.', ','),
        //     'totalVat' => number_format($data['totalVat'], 0, '.', ','),
        //     'client' => $client,
        // ]);
    }

    public function store()
    {
        $data = request()->validate([
            'project_title' => ['required', 'string'],
        ]);
        $quotationCode = [
            'table' => 'quotations',
            'field' => 'quotation_code',
            'length' => 7,
            'prefix' => 'MQ',
            'reset_on_prefix_change' => true,
        ];
        $data['quotation_code'] = IdGenerator::generate($quotationCode);
        $clientId = request()->input('selected_client');
        $data['client_name'] = request()->input('client_name');
        $customerType = request()->input('customer_type');
        if ($customerType == 1 && ! is_null($clientId)) {
            $client = Customer::where('id', $clientId)->first();
            $data['client_name'] = $client->customer_name;
            $data['client_id'] = $clientId;
        } elseif (is_null($data['client_name'])) {
            return redirect()->back()->with('error', 'Please fill form correctly');
        }

        $quotation = Quotation::create($data);

        return redirect()->route('quotation.items', $quotation->id)->with('success', 'Quotation created! Now you can start adding items');
    }

    public function update(Quotation $quotation)
    {
        $data = request()->validate([
            'project_title' => ['required', 'string'],
        ]);

        $clientId = request()->input('selected_client');
        $data['client_name'] = request()->input('client_name');
        $customerType = request()->input('customer_type');
        if ($customerType == 1 && ! is_null($clientId)) {
            $client = Customer::where('id', $clientId)->first();
            $data['client_name'] = $client->customer_name;
            $data['client_id'] = $clientId;
        } elseif (is_null($data['client_name'])) {
            return redirect()->back()->with('error', 'Please fill form correctly');
        }

        $quotation->update($data);

        return redirect()->back()->with('success', 'Quotation updated!');
    }

    public function delete(Quotation $quotation)
    {
        $quotation->delete();

        return redirect()->route('quotation.index')->with('success', 'Quotation deleted!');
    }
}
