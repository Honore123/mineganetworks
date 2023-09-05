@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12  ">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">{{$project->project_name}} project</h4>
            <p class="card-description">All documents are below</p>
            <ul class="nav nav-pills nav-pills-primary" id="pills-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="pills-quotation-tab" data-toggle="pill" href="#pills-quotation" role="tab" aria-controls="pills-quotation" aria-selected="true">Quotations</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="pills-po-tab" data-toggle="pill" href="#pills-po" role="tab" aria-controls="pills-po" aria-selected="false">Purchase order</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="pills-invoices-tab" data-toggle="pill" href="#pills-invoices" role="tab" aria-controls="pills-invoices" aria-selected="false">Invoices</a>
              </li>
            </ul>
            <div class="tab-content border-0 px-0" id="pills-tabContent">
              <div class="tab-pane fade show active" id="pills-quotation" role="tabpanel" aria-labelledby="pills-quotation-tab">
                <h5>List of quotations</h5>
              </div>
              <div class="tab-pane fade" id="pills-po" role="tabpanel" aria-labelledby="pills-po-tab">
                <h5>Purchase orders</h5>
              </div>
              <div class="tab-pane fade" id="pills-invoices" role="tabpanel" aria-labelledby="pills-invoices-tab">
                <h5>Invoices</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection
