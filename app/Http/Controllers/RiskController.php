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
            ->rawColumns(['option'])
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'risk_name' => ['required', 'string'],
        ]);

        Risk::create($data);

        return redirect()->back()->with('success', 'Risk added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Risk  $risk
     * @return \Illuminate\Http\Response
     */
    public function show(Risk $risk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Risk  $risk
     * @return \Illuminate\Http\Response
     */
    public function edit(Risk $risk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Risk  $risk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Risk $risk)
    {
        $data = request()->validate([
            'risk_name' => ['required', 'string'],
        ]);

        $risk->update($data);

        return redirect()->back()->with('success', 'Risk updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Risk  $risk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Risk $risk)
    {
        $risk->delete();

        return redirect()->back()->with('success', 'Risk deleted');
    }
}
