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
            <h3>Customers</h3>
        </div>
        <div class="col-md-12 d-flex justify-content-end">
            <a class="btn btn-primary rounded-0" data-toggle="modal" data-target="#new_customer">New Customer</a>
        </div>
        @include('customer.partials.add')
        <div class="col-md-12 mt-3">
            @include('layouts.partials.notification')
        </div>
        @include('customer.partials.edit')
        <div class="col-md-12 mt-4 bg-white p-3">
            <table class="table table-bordered table-striped table-hover table-responsive" id="customers-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>TIN</th>
                        <th>Status</th>
                        <th>Valid until</th>
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
                text:'The pricing book of '+ name +' will be removed, Do you want to delete customer '+ name,
                icon: 'warning',
                confirmButtonText: 'Yes',
                cancelButtonText:'No',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-customer-'+ id).submit();
                }
            });
        }
       function showModal(id){
        const customers = @json($customers);
        let customer = customers.find(customer=> customer.id == id);
        $("#edit_customer_name").val(customer.customer_name);
        $("#edit_email").val(customer.email);
        $("#edit_phone_number").val(customer.phone_number);
        $("#edit_address").val(customer.address);
        $("#edit_tin").val(customer.tin);
        $("#edit_start_date").val(customer.start_date);
        $("#edit_end_date").val(customer.end_date);
        $('#edit_customer_form').attr("action","{{route('customer.index')}}/"+id)
        $('#edit_customer').modal('show');
       }
        $('#customers-table').DataTable({
            'paging': true,
            'scrollX': false,
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
                "url": "{{route('customer.index')}}",
                "type": 'GET',
            },
            "columns": [
                {"data": 'DT_RowIndex', "name": 'DT_RowIndex', orderable: false,searchable: false,"className":"text-middle","width":"1%"},
                { "data": 'customer_name', "name": 'customer_name',"className":"text-middle","width":"30%"},
                { "data": 'email', "name": 'email',"className":"text-middle","width":"30%"},
                { "data": 'phone_number', "name": 'phone_number',"className":"text-middle"},
                { "data": 'tin', "name": 'tin',"className":"text-middle"},
                { "data": 'contract_status', "name": 'contract_status',"className":"text-middle"},
                { "data": 'end_date', "name": 'end_date',"className":"text-middle","width":"20%"},
                {"data": 'option', "name": 'option', orderable:false, searchable:false,"className":"text-middle"},
            ]
        })
</script>
@endpush