@extends('layouts.app')
@push('styles')
    <style>
        .table td{
            white-space: normal;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>Customers P.O</h3>
        </div>
        <div class="col-md-12 d-flex justify-content-end">
            <a class="btn btn-primary rounded-0" data-toggle="modal" data-target="#customer_po_add">New P.O</a>
        </div>
       @include('customer_po.partials.add')
        <div class="col-md-12 mt-3">
            @include('layouts.partials.notification')
        </div>
       @include('customer_po.partials.edit')
        <div class="col-md-12 mt-4 bg-white p-3">
            <table class="table table-bordered table-striped table-hover" id="customers-table" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>P.O No</th>
                        <th>Company</th>
                        <th>Project</th>
                        <th>Status</th>
                        <th>Total amount</th>
                        <th>Created date</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    function deleteAlert(id, name){
        swal.fire( {
            title:'Confirmation',
            text:'Are you sure you want to delete P.O_No: '+ name + ' ?',
            icon: 'warning',
            confirmButtonText: 'Yes',
            cancelButtonText:'No',
            showCancelButton: true,
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-customer-po-'+ id).submit();
            }
        });
    }
    function showModal(id){
        const purchaseOrders = @json($purchaseOrders);
        let purchaseOrder = purchaseOrders.find(purchaseOrder=> purchaseOrder.id == id);
        $("#edit_po_number").val(purchaseOrder.po_number);
        $("#edit_company_name").val(purchaseOrder.company_name);
        $("#edit_project_title").val(purchaseOrder.project_title);
        $("#edit_total_amount").val(purchaseOrder.total_amount);
        $('#edit_customer_po_form').attr("action","{{route('customer-po.index')}}/"+id)
        $('#customer_po_edit').modal('show');
       }
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
                "url": "{{route('customer-po.index')}}",
                "type": 'GET',
            },
            "columns": [
                {"data": 'DT_RowIndex', "name": 'DT_RowIndex', orderable: false,searchable: false,"className":"text-middle"},
                { "data": 'po_number', "name": 'po_number'},
                { "data": 'company_name', "name": 'company_name'},
                {"data": 'project_title', "name":'project_title',"defaultContent":'-',"className":"w-25"},
                { "data": 'status', "name": 'status',"className":"text-center"},
                { "data": 'total_amount', "name": 'total_amount',"className":"text-center"},
                { "data": 'created_at', "name": 'created_at',"className":"text-center"},
                {"data": 'option', "name": 'option', orderable:false, searchable:false,"className":"text-middle"},
            ]
        })
</script>
@endpush