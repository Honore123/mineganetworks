<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Project;
use App\Models\QuotationType;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;

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
        //
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
