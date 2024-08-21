<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectRisk;
use App\Models\Risk;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectRiskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        $risks = ProjectRisk::with(['risk', 'project'])->where('project_id', $project->id)->orderBy('created_at', 'DESC')->get();

        if (request()->ajax()) {
            return datatables($risks)
                ->editColumn('option', 'risk-management.partials.action')
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

        return view('risk-management.index', [
            'project' => $project,
            'risks' => Risk::all(),
            'projectRisks' => $risks,
        ]);
    }

    public function chart(Project $project)
    {
        $response = DB::table('project_risks')
        ->join('risks', 'risks.id', '=', 'project_risks.risk_id')
        ->select('project_risks.risk_id', 'risks.risk_name', 'risks.risk_severity', DB::raw('count(risk_id) as total_risks'))
        ->groupBy('project_risks.risk_id', 'risks.risk_name', 'risks.risk_severity')
        ->where('project_risks.project_id', $project->id)
        ->get();

        return response()->json($response);
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
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project)
    {
        $data = request()->validate([
            'risk_id' => ['required'],
            'reportee' => ['required', 'string'],
            'reported_at' => ['required'],
            'assigned_to' => ['required'],
            'comment'=>['nullable'],
            'site_id' => ['required', 'string'],
            'site_name' => ['required', 'string'],
        ]);
        $data['project_id'] = $project->id;
        $data['reported_at'] = Carbon::parse($data['reported_at'])->toDateTimeString();
        ProjectRisk::create($data);

        return redirect()->back()->with('success', 'Issue registered!');
    }

    /**
     * Display the specified resource.
     *
     * @param  ProjectRisk  $projectRisk
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectRisk $projectRisk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ProjectRisk  $projectRisk
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectRisk $projectRisk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  ProjectRisk  $projectRisk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectRisk $projectRisk)
    {
        $data = request()->validate([
            'risk_id' => ['required'],
            'reportee' => ['required', 'string'],
            'reported_at' => ['required'],
            'assigned_to' => ['required'],
            'comment'=>['nullable'],
            'site_id' => ['required', 'string'],
            'site_name' => ['required', 'string'],
        ]);

        $data['reported_at'] = Carbon::parse($data['reported_at'])->toDateTimeString();
        $projectRisk->update($data);

        return redirect()->back()->with('success', 'Project issue updated!');
    }

    public function resolve(ProjectRisk $projectRisk)
    {
        $data = request()->validate([
            'solution' => ['required'],
            'resolved_at' => ['required'],
        ]);
        $data['resolved_at'] = Carbon::parse($data['resolved_at'])->toDateTimeString();
        $projectRisk->update($data);

        return redirect()->back()->with('success', 'Issue resolved successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ProjectRisk  $projectRisk
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectRisk $projectRisk)
    {
        $projectRisk->delete();

        return redirect()->back()->with('success', 'Risk removed from project!');
    }
}
