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
            <h3>Riggers</h3>
        </div>
        <div class="col-md-12 d-flex justify-content-end">
            <a class="btn btn-outline-success rounded-0 mr-3" href="{{route('riggers.export-excel')}}">Export Excel</a>
            <a class="btn btn-outline-primary rounded-0 mr-3" href="{{route('riggers.download')}}">Download PDF</a>
            <a class="btn btn-primary rounded-0" data-toggle="modal" data-target="#new_rigger">New Rigger</a>
        </div>
        @include('riggers.partials.add')
        <div class="col-md-12 mt-3">
            @include('layouts.partials.notification')
        </div>
        @include('riggers.partials.edit')
        <div class="col-md-12 mt-4 bg-white p-3">
            <table class="table table-bordered table-striped table-hover table-responsive" id="customers-table" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone number</th>
                        <th>ID Number</th>
                        <th>Certificates</th>
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
                text:'Rigger account of  '+ name +' will be removed, Do you want to delete?',
                icon: 'warning',
                confirmButtonText: 'Yes',
                cancelButtonText:'No',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-rigger-'+ id).submit();
                }
            });
        }
       function showModal(id){
        const riggers = @json($riggers);
        let rigger = riggers.find(rigger=> rigger.id == id);
        $("#edit_name").val(rigger.name);
        $("#edit_phone").val(rigger.phone);
        $("#edit_nid").val(rigger.nid);
        $('#edit_rigger_form').attr("action","{{route('riggers.index')}}/"+id)
        $('#edit_rigger').modal('show');
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
                "url": "{{route('riggers.index')}}",
                "type": 'GET',
            },
            "columns": [
                {"data": 'DT_RowIndex', "name": 'DT_RowIndex', orderable: false,searchable: false,"className":"text-middle","width":"1%"},
                { "data": 'name', "name": 'name',"className":"text-middle","width":"20%"},
                { "data": 'phone', "name": 'phone',"className":"text-middle","width":"10%"},
                { "data": 'nid', "name": 'nid',"className":"text-middle","width":"10%"},
                { "data": 'document', "name": 'document',"className":"text-middle","width":"50%", searchable:false},
                {"data": 'option', "name": 'option', orderable:false, searchable:false,"className":"text-middle"},
            ],
            "buttons": [
                {extend: 'colvis', className: 'btn btn-warning', columns: ':visible'},
            ],
        })
</script>
@endpush