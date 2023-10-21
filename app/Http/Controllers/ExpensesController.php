<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use App\Models\Project;
use Illuminate\Http\Request;

class ExpensesController extends Controller
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
    public function store(Project $project)
    {
        $data = request()->validate([
            'expense_name' => ['required'],
            'expense_amount' => ['required'],
        ]);
        $data['project_id'] = $project->id;

        Expenses::create($data);

        return redirect()->back()->with('success', 'Expense added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function show(Expenses $expenses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function edit(Expenses $expenses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expenses $expense)
    {
        $data = request()->validate([
            'expense_name' => ['required'],
            'expense_amount' => ['required'],
        ]);

        $expense->update($data);

        return redirect()->back()->with('success', 'Expense updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expenses $expense)
    {
        $expense->delete();

        return redirect()->back()->with('success', 'Expense deleted!');
    }
}
