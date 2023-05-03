<?php

namespace App\Http\Controllers;

use App\Models\MeasurementUnit;

class MeasurementUnitController extends Controller
{
    public function index()
    {
        return view('unit.index', [
            'units'=> MeasurementUnit::all(),
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'unit_name' => ['required', 'string'],
            'unit_abbr' => ['required', 'string'],
        ]);

        MeasurementUnit::create($data);

        return redirect()->back()->with('success', 'Unit created!');
    }

    public function update()
    {
    }

    public function delete()
    {
    }
}
