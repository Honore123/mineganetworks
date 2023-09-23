<?php

namespace App\Http\Controllers;

use App\Models\ProjectAcceptance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProjectAcceptanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'customer_purchase_order_id' => ['required', 'unique:project_acceptances,deleted_at,NULL'],
        ], ['customer_purchase_order_id' => 'Please select purchase order', 'customer_purchase_order_id.unique' =>'PO already used in other acceptance documents']);

        $file = request()->file('acceptance_document');
        if ($file) {
            $data['acceptance_document'] = uniqid().'_'.trim($file->getClientOriginalName());
            $file->storeAs('acceptance/', $data['acceptance_document'], 'public');
        } else {
            return redirect()->back()->with('error', 'Please add acceptance file');
        }
        ProjectAcceptance::create($data);

        return redirect()->back()->with('success', 'Acceptance uploaded successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectAcceptance  $projectAcceptance
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectAcceptance $projectAcceptance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectAcceptance  $projectAcceptance
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectAcceptance $projectAcceptance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectAcceptance  $projectAcceptance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectAcceptance $acceptance)
    {
        $data = request()->validate([
            'customer_purchase_order_id' => ['required', Rule::unique('project_acceptances')->ignore($acceptance->id)->whereNull('deleted_at')],
        ], ['customer_purchase_order_id' => 'Please select purchase order', 'customer_purchase_order_id.unique' =>'PO already used in other acceptance documents']);

        $file = request()->file('acceptance_document');
        if ($file) {
            $data['acceptance_document'] = uniqid().'_'.trim($file->getClientOriginalName());
            $file->storeAs('acceptance/', $data['acceptance_document'], 'public');
        }
        $acceptance->update($data);

        return redirect()->back()->with('success', 'Acceptance updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectAcceptance  $projectAcceptance
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectAcceptance $acceptance)
    {
        $acceptance->delete();

        return redirect()->back()->with('success', 'Acceptance document deleted!');
    }
}
