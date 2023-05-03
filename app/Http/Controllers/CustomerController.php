<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use DateTime;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::query()->get();
        if (request()->ajax()) {
            return datatables($customers)
            ->editColumn('contract_duration', function ($customer) {
                $date1 = new DateTime($customer->start_date);
                $date2 = new DateTime($customer->end_date);
                $interval = $date1->diff($date2);

                return $interval->days.' days';
            })
            ->editColumn('contract_status', function ($customer) {
                if ($customer->contract_status == 1 && new DateTime($customer->end_date) >= new DateTime('today')) {
                    return '<span class="badge badge-success">Active</span>';
                } else {
                    return '<span class="badge badge-danger">Expired</span>';
                }
            })
            ->editColumn('end_date', function ($customer) {
                $date = new DateTime($customer->end_date);

                return $date->format('d/m/Y');
            })
            ->editColumn('option', 'customer.partials.action')
            ->rawColumns(['contract_status', 'option'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('customer.index', ['customers'=>$customers]);
    }

    public function store()
    {
        $data = request()->validate([
            'customer_name' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ]);

        $data['contract_status'] = 1;
        if (new DateTime($data['end_date']) < new DateTime($data['start_date'])) {
            return redirect()->back()->with('error', 'Contract end date is less than contract start date');
        }

        if (new DateTime($data['end_date']) <= new DateTime('today')) {
            $data['contract_status'] = 0;
        }
        Customer::create($data);

        return redirect()->back()->with('success', 'Customer framework created');
    }

    public function update(Customer $customer)
    {
        $data = request()->validate([
            'customer_name' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ]);
        $data['contract_status'] = 1;
        if (new DateTime($data['end_date']) < new DateTime($data['start_date'])) {
            return redirect()->back()->with('error', 'Contract end date is less than contract start date');
        }
        if (new DateTime($data['end_date']) <= new DateTime('today')) {
            $data['contract_status'] = 0;
        }
        $customer->update($data);

        return redirect()->back()->with('success', 'Customer framework updated');
    }

    public function delete(Customer $customer)
    {
        $customer->delete();

        return redirect()->back()->with('success', 'Customer deleted');
    }
}
