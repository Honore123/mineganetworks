<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectRisk;
use App\Models\Risk;
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
                ->rawColumns(['option'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('risk-management.index', [
            'project' => $project,
            'risks' => Risk::all(),
        ]);
    }

    public function chart(Project $project)
    {
        $response = DB::table('project_risks')
        ->join('risks', 'risks.id', '=', 'project_risks.risk_id')
        ->select('project_risks.risk_id', 'risks.risk_name', DB::raw('count(risk_id) as total_risks'))
        ->groupBy('project_risks.risk_id')
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project)
    {
        $data = request()->validate([
            'risk_id' => ['required'],
            'reportee' => ['required', 'string'],
        ]);
        $data['project_id'] = $project->id;
        ProjectRisk::create($data);

        return redirect()->back()->with('success', 'Risk registered!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectRisk  $projectRisk
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectRisk $projectRisk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectRisk  $projectRisk
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectRisk $projectRisk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectRisk  $projectRisk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectRisk $projectRisk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectRisk  $projectRisk
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectRisk $projectRisk)
    {
        $projectRisk->delete();

        return redirect()->back()->with('success', 'Risk removed from project!');
    }
}
