@extends('layouts.app')

@section('content')
    <div class="row mb-5">
        <div class="col-md-12">
            <h3>Welcome {{auth()->user()->name}}</h3>
            <h6 class="font-weight-normal mb-0">Below are data within past <span class="text-primary">30 days!</span></h6>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <a class="card card-tale text-decoration-none" href="{{route('quotation.index')}}" role="button">
                    <div class="card-body">
                      <p class="mb-4">Total Quotations</p>
                      <p class="fs-30 mb-2">{{$quotation}}</p>
                      <p>(30 days)</p>
                    </div>
                  </a>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent ">
                  <a class="card card-dark-blue text-decoration-none" href="{{route('invoice.index')}}" role="button">
                    <div class="card-body">
                      <p class="mb-4">Total Invoices</p>
                      <p class="fs-30 mb-2">{{$invoice}}</p>
                      <p>(30 days)</p>
                    </div>
                  </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                    <a class="card text-light text-decoration-none" href="{{route('purchase-order.index')}}" role="button" style="background: #2f3683">
                    <div class="card-body">
                        <p class="mb-4">Total POs</p>
                        <p class="fs-30 mb-2">{{$purchaseOrder}}</p>
                        <p>(30 days)</p>
                    </div>
                    </a>
                </div>
                <div class="col-md-6 stretch-card transparent">
                    <a class="card text-light text-decoration-none" href="{{route('riggers.index')}}" role="button" style="background: #c7ad36">
                    <div class="card-body">
                        <p class="mb-4">Number of Riggers</p>
                        <p class="fs-30 mb-2">{{$rigger}}</p>
                        <p>(All)</p>
                    </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                    <table class="table table-bordered bg-white table-striped">
                      <thead>
                        <tr>
                          <th class="bg-primary text-white">Item</th>
                          <th class="bg-success text-white">Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><h5>Uninvoiced P.O amount</h5></td>
                          <td><h6>{{number_format($total_unpaid_amount,2,'.',',') }} Rwf</h6></td>
                        </tr>
                        <tr>
                          <td><h5>Invoiced P.Os amount</h5></td>
                          <td><h6>{{number_format($total_invoiced_amount,2,'.',',') }} Rwf</h6></td>
                        </tr>
                        <tr>
                          <td><h5>Paid P.Os amount</h5></td>
                          <td><h6>{{number_format($total_paid_amount,2,'.',',') }} Rwf</h6></td>
                        </tr>
                        <tr>
                          <td><h5>Total P.Os amount</h5></td>
                          <td><h6>{{number_format($total_po_amount,2,'.',',')}} Rwf</h6></td>
                        </tr>
                      </tbody>
                    </table>
              </div>
            </div>
        </div>
    </div>

@endsection