<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerPurchaseOrder;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\ProjectAcceptance;
use App\Models\ProjectRisk;
use App\Models\Quotation;
use App\Models\QuotationType;
use App\Models\Risk;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::orderBy('created_at', 'DESC')->get();
        if (request()->ajax()) {
            return datatables($projects)
                ->editColumn('created_at', function ($project) {
                    return $project->created_at->format('d/m/Y');
                })
                ->editColumn('option', 'projects.partials.action')
                ->rawColumns(['option'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('projects.index', [
            'projects' => $projects,
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
            'project_name' => ['required', 'string'],
        ]);

        $projectCode = [
            'table' => 'projects',
            'field' => 'project_code',
            'length' => 7,
            'prefix' => 'P',
            'reset_on_prefix_change' => true,
        ];
        $data['project_code'] = IdGenerator::generate($projectCode);
        $clientId = request()->input('selected_client');
        $customerType = request()->input('customer_type');
        $data['company_name'] = request()->input('company_name');
        if ($customerType == 1 && ! is_null($clientId)) {
            $client = Customer::where('id', $clientId)->first();
            $data['company_name'] = $client->customer_name;
            $data['client_id'] = $clientId;
        } elseif (is_null($data['company_name'])) {
            return redirect()->back()->with('error', 'Please fill form correctly');
        }
        Project::create($data);

        return redirect()->back()->with('success', 'Project created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $risks = ProjectRisk::with(['risk', 'project'])->where('project_id', $project->id)->orderBy('created_at', 'DESC')->get();
        $acceptance = ProjectAcceptance::whereHas('purchase', function ($query) use ($project) {
            $query->where('project_id', $project->id);
        })->with(['purchase'])->orderBy('created_at', 'DESC')->get();

        return view('projects.show', [
            'types' => QuotationType::all(),
            'customers' => Customer::all(),
            'project' => $project,
            'risks' => Risk::all(),
            'projectRisks' => $risks,
            'customerPOs' => CustomerPurchaseOrder::where('project_id', $project->id)->get(),
            'acceptances' => $acceptance,
        ]);
    }

    public function quotation(Project $project)
    {
        $quotations = Quotation::where('project_id', $project->id)->with(['project'])->orderBy('created_at', 'DESC')->get();

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
    }

    public function customerPo(Project $project)
    {
        $customersPo = CustomerPurchaseOrder::where('project_id', $project->id)->orderBy('created_at', 'DESC')->get();

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
                    return $purchaseOrder->created_at->format('d-m-Y');
                })
                ->editColumn('total_amount', function ($purchaseOrder) {
                    return number_format((float) $purchaseOrder->total_amount, 2, '.', ',').' Rwf';
                })
                ->editColumn('remaining_amount', function ($purchaseOrder) {
                    return number_format((float) $purchaseOrder->remaining_amount, 2, '.', ',').' Rwf';
                })
                ->editColumn('option', 'customer_po.partials.action')
                ->rawColumns(['option', 'status'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function invoice(Project $project)
    {
        $invoices = Invoice::whereHas('purchaseOrder', function ($query) use ($project) {
            $query->where('project_id', $project->id);
        })->with(['purchaseOrder'])->orderBy('created_at', 'DESC')->get();

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

                    return number_format($total_inc_vat, 0, '.', ',').' Rwf';
                })
                ->rawColumns(['option', 'status'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function issues(Project $project)
    {
        $risks = ProjectRisk::with(['risk', 'project'])->where('project_id', $project->id)->orderBy('created_at', 'DESC')->get();
        if (request()->ajax()) {
            return datatables($risks)
                ->editColumn('option', 'projects.partials.risk-management.partials.action')
                ->editColumn('created_at', function ($risk) {
                    return $risk->created_at->format('d/m/Y');
                })
                ->editColumn('solution', function ($risk) {
                    if (! is_null($risk->solution)) {
                        return $risk->solution;
                    }

                    return '<span class="badge bg-warning w-100">Pending</span>';
                })
                ->rawColumns(['option', 'solution'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $data = request()->validate([
            'project_name' => ['required', 'string'],
        ]);

        $clientId = request()->input('selected_client');
        $customerType = request()->input('customer_type');
        $data['company_name'] = request()->input('company_name');
        $data['client_id'] = 0;
        if ($customerType == 1 && ! is_null($clientId)) {
            $client = Customer::where('id', $clientId)->first();
            $data['company_name'] = $client->customer_name;
            $data['client_id'] = $clientId;
        } elseif (is_null($data['company_name'])) {
            return redirect()->back()->with('error', 'Please fill form correctly');
        }
        $project->update($data);

        return redirect()->back()->with('success', 'Project updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->back()->with('success', 'Project deleted');
    }
}
