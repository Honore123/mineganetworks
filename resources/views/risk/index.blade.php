@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>Issues</h3>
        </div>
        <div class="col-md-12 d-flex justify-content-end">
            <a class="btn btn-primary rounded-0" data-toggle="modal" data-target="#risk_add">New Issue</a>
        </div>
       @include('risk.partials.add')
        <div class="col-md-12 mt-3">
            @include('layouts.partials.notification')
        </div>
       @include('risk.partials.edit')
        <div class="col-md-12 mt-4 bg-white p-3">
            <table class="table table-bordered table-striped table-hover" id="customers-table" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
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
                text:'Are you sure you want to delete '+ name + ' ?',
                icon: 'warning',
                confirmButtonText: 'Yes',
                cancelButtonText:'No',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-risk-'+ id).submit();
                }
            });
        }

    function showModal(id){
        const risks = @json($risks);
        let risk = risks.find(risk=> risk.id == id);
        $("#edit_risk_name").val(risk.risk_name);
        $('#edit_risk_form').attr("action","{{route('risk.index')}}/"+id)
        $('#risk_edit').modal('show');
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
                "url": "{{route('risk.index')}}",
                "type": 'GET',
            },
            "columns": [
                {"data": 'DT_RowIndex', "name": 'DT_RowIndex', orderable: false,searchable: false,"className":"text-middle"},
                { "data": 'risk_name', "name": 'risk_name',"className":"text-middle"},
                {"data": 'option', "name": 'option', orderable:false, searchable:false,"className":"text-middle"},
            ]
        })
</script>
@endpush