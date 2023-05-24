<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use DateTime;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::query()->get();
        if (request()->ajax()) {
            return datatables($vendors)
            ->editColumn('contract_duration', function ($vendor) {
                $date1 = new DateTime($vendor->start_date);
                $date2 = new DateTime($vendor->end_date);
                $interval = $date1->diff($date2);

                return $interval->days.' days';
            })
            ->editColumn('contract_status', function ($vendor) {
                if ($vendor->contract_status == 1 && new DateTime($vendor->end_date) >= new DateTime('today')) {
                    return '<span class="badge badge-success">Active</span>';
                } else {
                    return '<span class="badge badge-danger">Expired</span>';
                }
            })
            ->editColumn('end_date', function ($vendor) {
                $date = new DateTime($vendor->end_date);

                return $date->format('d/m/Y');
            })
            ->editColumn('option', 'vendor.partials.action')
            ->rawColumns(['contract_status', 'option'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('vendor.index', ['vendors'=>$vendors]);
    }

    public function store()
    {
        $data = request()->validate([
            'vendor_name' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'tin' => ['required'],
            'phone_number' => ['required'],
            'email' => ['string'],
            'nat_id' => ['string'],
        ]);

        $data['contract_status'] = 1;

        if (new DateTime($data['end_date']) < new DateTime($data['start_date'])) {
            return redirect()->back()->with('error', 'Contract end date is less than contract start date');
        }

        if (new DateTime($data['end_date']) <= new DateTime('today')) {
            $data['contract_status'] = 0;
        }
        Vendor::create($data);

        return redirect()->back()->with('success', 'Vendor created');
    }

    public function update(Vendor $vendor)
    {
        $data = request()->validate([
            'vendor_name' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'tin' => ['required'],
            'phone_number' => ['required'],
            'email' => ['string'],
            'nat_id' => ['string'],
        ]);
        $data['contract_status'] = 1;
        if (new DateTime($data['end_date']) < new DateTime($data['start_date'])) {
            return redirect()->back()->with('error', 'Contract end date is less than contract start date');
        }
        if (new DateTime($data['end_date']) < new DateTime('today')) {
            $data['contract_status'] = 0;
        }
        $vendor->update($data);

        return redirect()->back()->with('success', 'Vendor updated');
    }

    public function delete(Vendor $vendor)
    {
        $vendor->delete();

        return redirect()->back()->with('success', 'Vendor deleted');
    }
}
