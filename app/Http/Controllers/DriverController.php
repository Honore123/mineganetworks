<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::all();

        if (request()->ajax()) {
            return datatables($drivers)
            ->editColumn('option', 'drivers.partials.action')
            ->rawColumns(['option'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('drivers.index', ['drivers'=>$drivers]);
    }

    public function store()
    {
        $data = request()->validate([
            'driver_name' => ['required', 'string'],
            'phone_number' => ['required'],
            'vehicle_type' => ['required', 'string'],
        ]);

        Driver::create($data);

        return redirect()->back()->with('success', 'Driver added');
    }

    public function update(Driver $driver)
    {
        $data = request()->validate([
            'driver_name' => ['required', 'string'],
            'phone_number' => ['required'],
            'vehicle_type' => ['required', 'string'],
        ]);

        $driver->update($data);

        return redirect()->back()->with('success', 'Driver '.$driver->driver_name.' updated');
    }

    public function delete(Driver $driver)
    {
        $driver->delete();

        return redirect()->back()->with('success', 'Driver deleted');
    }
}
