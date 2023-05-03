@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>Vendors</h3>
        </div>
        <div class="col-md-12 d-flex justify-content-end">
            <a class="btn btn-primary rounded-0 mr-4" data-toggle="modal" data-target="#new_vendor">New Vendor</a>
        </div>
        @include('vendor.partials.add')
        <div class="col-md-12 mt-3">
            @include('layouts.partials.notification')
        </div>
        @include('vendor.partials.edit')
        <div class="col-md-12 mt-4 bg-white p-3">
            <table class="table table-bordered table-striped table-hover" id="customers-table" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
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
                text:'The pricing book of '+ name +' will be removed, Do you want to delete vendor '+ name,
                icon: 'warning',
                confirmButtonText: 'Yes',
                cancelButtonText:'No',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-vendor-'+ id).submit();
                }
            });
        }
       function showModal(id){
        const vendors = @json($vendors);
        let vendor = vendors.find(vendor=> vendor.id == id);
        $("#edit_vendor_name").val(vendor.vendor_name);
        $("#edit_start_date").val(vendor.start_date);
        $("#edit_end_date").val(vendor.end_date);
        $('#edit_vendor_form').attr("action","{{route('vendor.index')}}/"+id)
        $('#edit_vendor').modal('show');
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
                "url": "{{route('vendor.index')}}",
                "type": 'GET',
            },
            "columns": [
                {"data": 'DT_RowIndex', "name": 'DT_RowIndex', orderable: false,searchable: false,"className":"text-middle"},
                { "data": 'vendor_name', "name": 'vendor_name',"className":"text-middle"},
                { "data": 'contract_status', "name": 'contract_status',"className":"text-middle"},
                { "data": 'end_date', "name": 'end_date',"className":"text-middle"},
                {"data": 'option', "name": 'option', orderable:false, searchable:false,"className":"text-middle"},
            ]
        })
</script>
@endpush