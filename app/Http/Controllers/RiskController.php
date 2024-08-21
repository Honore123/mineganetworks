<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Risk;
use Illuminate\Http\Request;

class RiskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $risks = Risk::orderBy('created_at', 'DESC')->get();
        if (request()->ajax()) {
            return datatables($risks)
            ->editColumn('option', 'risk.partials.action')
            ->editColumn('risk_severity', function ($risk) {
                if ($risk->risk_severity == 'High') {
                    return '<span class="badge badge-danger px-3 py-2 w-100">'.$risk->risk_severity.'</span>';
                } elseif ($risk->risk_severity == 'Medium') {
                    return '<span class="badge badge-warning px-3 py-2 w-100">'.$risk->risk_severity.'</span>';
                } else {
                    return '<span class="badge badge-success px-3 py-2 w-100">'.$risk->risk_severity.'</span>';
                }
            })
            ->rawColumns(['option', 'risk_severity'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('risk.index', [
            'risks' => $risks,
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
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'risk_name' => ['required', 'string'],
            'risk_severity' => ['required', 'string'],
            'risk_description' => ['nullable', 'string'],
        ]);

        Risk::create($data);

        return redirect()->back()->with('success', 'Risk added');
    }

    /**
     * Display the specified resource.
     *
     * @param  Risk  $risk
     * @return \Illuminate\Http\Response
     */
    public function show(Risk $risk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Risk  $risk
     * @return \Illuminate\Http\Response
     */
    public function edit(Risk $risk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Risk  $risk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Risk $risk)
    {
        $data = request()->validate([
            'risk_name' => ['required', 'string'],
            'risk_severity' => ['required', 'string'],
            'risk_description' => ['nullable', 'string'],
        ]);

        $risk->update($data);

        return redirect()->back()->with('success', 'Risk updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Risk  $risk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Risk $risk)
    {
        $risk->delete();

        return redirect()->back()->with('success', 'Risk deleted');
    }
}
