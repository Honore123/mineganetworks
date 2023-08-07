@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 d-flex flex-wrap justify-content-between">
            <h3>Risk management</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('projects-risks.index')}}">Projects</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$project->project_name}}'s risks</li>
                </ol>
            </nav>
        </div>
       @include('risk-management.partials.add')
        <div class="col-md-12 mt-3">
            @include('layouts.partials.notification')
        </div>
       {{-- @include('risk.partials.edit') --}}
        <div class="col-md-12 mt-3 bg-white p-3">
            <div class="col-md-12 mt-3 mb-4 pr-0 d-flex justify-content-end">
                <a class="btn btn-primary rounded-0" data-toggle="modal" data-target="#risk_add">New Inquiry</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="customers-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Risk</th>
                            <th>Reportee</th>
                            <th>Date</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
           
        </div>
    </div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
     $(document).ready(function(){
            $('#risk_id').select2();
           
        });
        function deleteAlert(id, name){
            swal.fire( {
                title:'Confirmation',
                text:'Are you sure you want to remove '+ name + ' risk ?',
                icon: 'warning',
                confirmButtonText: 'Yes',
                cancelButtonText:'No',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-risk-project-'+ id).submit();
                }
            });
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
                "url": "{{route('risk-management.index',$project->id)}}",
                "type": 'GET',
            },
            "columns": [
                {"data": 'DT_RowIndex', "name": 'DT_RowIndex', orderable: false,searchable: false,"className":"text-middle"},
                { "data": 'risk.risk_name', "name": 'risk.risk_name',"className":"text-middle"},
                { "data": 'reportee', "name": 'reportee',"className":"text-middle"},
                { "data": 'created_at', "name": 'risk.created_at',"className":"text-middle"},
                {"data": 'option', "name": 'option', orderable:false, searchable:false,"className":"text-middle"},
            ]
        })
</script>
@endpush