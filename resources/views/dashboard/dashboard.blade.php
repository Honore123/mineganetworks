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
                  <div class="card card-tale">
                    <div class="card-body">
                      <p class="mb-4">Total Quotations</p>
                      <p class="fs-30 mb-2">{{$quotation}}</p>
                      <p>(30 days)</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card card-dark-blue">
                    <div class="card-body">
                      <p class="mb-4">Total Invoices</p>
                      <p class="fs-30 mb-2">{{$invoice}}</p>
                      <p>(30 days)</p>
                    </div>
                  </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                    <div class="card text-light" style="background: #2f3683">
                    <div class="card-body">
                        <p class="mb-4">Total POs</p>
                        <p class="fs-30 mb-2">{{$purchaseOrder}}</p>
                        <p>(30 days)</p>
                    </div>
                    </div>
                </div>
                <div class="col-md-6 stretch-card transparent">
                    <div class="card text-light" style="background: #c7ad36">
                    <div class="card-body">
                        <p class="mb-4">Number of Riggers</p>
                        <p class="fs-30 mb-2">{{$rigger}}</p>
                        <p>(All)</p>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection