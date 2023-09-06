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
              <li class="nav-item">
                <a class="nav-link" id="pills-issues-tab" data-toggle="pill" href="#pills-issues" role="tab" aria-controls="pills-issues" aria-selected="false">Issues</a>
              </li>
            </ul>
            <div class="tab-content border-0 px-0" id="pills-tabContent">
              <div class="tab-pane fade show active" id="pills-quotation" role="tabpanel" aria-labelledby="pills-quotation-tab">
                <h5>List of quotations</h5>
                <div class="row">
                  @include('projects.partials.quotation')
                </div>
              </div>
              <div class="tab-pane fade" id="pills-po" role="tabpanel" aria-labelledby="pills-po-tab">
                <h5>Purchase orders</h5>
                <div class="row">
                  @include('projects.partials.customer_po')
                </div>
              </div>
              <div class="tab-pane fade" id="pills-invoices" role="tabpanel" aria-labelledby="pills-invoices-tab">
                <h5>Invoices</h5>
                <div class="row">
                  @include('projects.partials.invoice')
                </div>
              </div>
              <div class="tab-pane fade" id="pills-issues" role="tabpanel" aria-labelledby="pills-issues-tab">
                <h5>Issues</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection
@push('scripts')
<script>
  $('#quotations-table').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'responsive': false,
            "aLengthMenu": [[10,25, 50, 75, -1], [10,25, 50, 75, "All"]],
            "iDisplayLength": 25,
            "processing":true,
            "serverSide":true,
            "ajax": {
                "url": "{{route('project.quotation',$project->id)}}",
                "type": 'GET',
            },
            "columns": [
                {"data": 'DT_RowIndex', "name": 'DT_RowIndex', orderable: false,searchable: false,"className":"text-middle"},
                { "data": 'quotation_code', "name": 'quotation_code'},
                { "data": 'project_title', "name": 'project_title',"className":"w-25"},
                { "data": 'total_inc_vat', "name": 'total_inc_vat',"className":"text-middle"},
                { "data": 'date', "name": 'date',"className":"text-middle"},
                {"data": 'option', "name": 'option', orderable:false, searchable:false,"className":"text-middle"},
            ]
        })
        $('#customers-table').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'responsive': true,
            "aLengthMenu": [[10,25, 50, 75, -1], [10,25, 50, 75, "All"]],
            "iDisplayLength": 10,
            "processing":true,
            "serverSide":true,
            "ajax": {
                "url": "{{route('project.customer-po',$project->id)}}",
                "type": 'GET',
            },
            "columns": [
                {"data": 'DT_RowIndex', "name": 'DT_RowIndex', orderable: false,searchable: false,"className":"text-middle"},
                { "data": 'po_number', "name": 'po_number'},
                { "data": 'status', "name": 'status',"className":"text-center"},
                { "data": 'total_amount', "name": 'total_amount',"className":"text-center"},
                { "data": 'remaining_amount', "name": 'remaining_amount',"className":"text-center"},
                { "data": 'created_at', "name": 'created_at',"className":"text-center"},
                {"data": 'option', "name": 'option', orderable:false, searchable:false,"className":"text-middle"},
            ]
        })
        $('#invoices-table').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'responsive': false,
            "aLengthMenu": [[10,25, 50, 75, -1], [10,25, 50, 75, "All"]],
            "iDisplayLength": 10,
            "processing":true,
            "serverSide":true,
            "ajax": {
                "url": "{{route('project.invoice',$project->id)}}",
                "type": 'GET',
            },
            "columns": [
                {"data": 'DT_RowIndex', "name": 'DT_RowIndex', orderable: false,searchable: false,"className":"text-middle"},
                { "data": 'invoice_code', "name": 'invoice_code'},
                { "data": 'status', "name": 'status',"className":"text-middle"},
                { "data": 'purchase_order.po_number', "name": 'purchase_order.po_number',"defaultContent":'-',"className":"text-middle"},
                { "data": 'total_inc_vat', "name": 'total_inc_vat',"className":"text-middle"},
                { "data": 'date', "name": 'date',"className":"text-middle"},
                {"data": 'option', "name": 'option', orderable:false, searchable:false,"className":"text-middle"},
            ]
        })
</script>
@endpush