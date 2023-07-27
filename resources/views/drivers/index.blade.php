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
            <h3>Drivers</h3>
        </div>
        <div class="col-md-12 d-flex justify-content-end">
            <a class="btn btn-primary rounded-0" data-toggle="modal" data-target="#new_driver">New Driver</a>
        </div>
        @include('drivers.partials.add')
        <div class="col-md-12 mt-3">
            @include('layouts.partials.notification')
        </div>
        @include('drivers.partials.edit')
        <div class="col-md-12 mt-4 bg-white p-3">
            <table class="table table-bordered table-striped table-hover" id="customers-table" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone number</th>
                        <th>Vehicle type</th>
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
                text:'Driver account of  '+ name +' will be removed, Do you want to delete?',
                icon: 'warning',
                confirmButtonText: 'Yes',
                cancelButtonText:'No',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-driver-'+ id).submit();
                }
            });
        }
       function showModal(id){
        const drivers = @json($drivers);
        let driver = drivers.find(driver=> driver.id == id);
        $("#edit_name").val(driver.driver_name);
        $("#edit_phone").val(driver.phone_number);
        $("#edit_vehicle_type").val(driver.vehicle_type);
        $('#edit_driver_form').attr("action","{{route('drivers.index')}}/"+id)
        $('#edit_driver').modal('show');
       }
        $('#customers-table').DataTable({
            'dom':'lBfrtip',
            'scrollX': false,
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
                "url": "{{route('drivers.index')}}",
                "type": 'GET',
            },
            "columns": [
                {"data": 'DT_RowIndex', "name": 'DT_RowIndex', orderable: false,searchable: false,"className":"text-middle"},
                { "data": 'driver_name', "name": 'driver_name',"className":"text-middle"},
                { "data": 'phone_number', "name": 'phone_number',"className":"text-middle"},
                { "data": 'vehicle_type', "name": 'vehicle_type',"className":"text-middle"},
                {"data": 'option', "name": 'option', orderable:false, searchable:false,"className":"text-middle"},
            ],
            "buttons": [
                {extend: 'colvis', className: 'btn btn-warning', columns: ':visible'},
            ],
        })
</script>
@endpush