@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>Projects</h3>
        </div>
        <div class="col-md-12 d-flex justify-content-end">
            <a class="btn btn-primary rounded-0" data-toggle="modal" data-target="#project_add">Create project</a>
        </div>
        @include('projects.partials.add')
        <div class="col-md-12 mt-3">
            @include('layouts.partials.notification')
        </div>
        @include('projects.partials.edit')
        <div class="col-md-12 mt-4 bg-white p-3">
            <table class="table table-bordered table-striped table-hover" id="customers-table" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Client/Company</th>
                        <th>Date</th>
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
                text:'All risks registered on this project will be deleted! Are you sure you want to delete '+ name + ' ?',
                icon: 'warning',
                confirmButtonText: 'Yes',
                cancelButtonText:'No',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-project-'+ id).submit();
                }
            });
        }

    function showModal(id){
        const projects = @json($projects);
        let project = projects.find(project=> project.id == id);
        $("#edit_project_name").val(project.project_name);
        $("#edit_company_name").val(project.company_name);
        $('#edit_project_form').attr("action","{{route('projects-risks.index')}}/"+id)
        $('#project_edit').modal('show');
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
                "url": "{{route('projects-risks.index')}}",
                "type": 'GET',
            },
            "columns": [
                {"data": 'DT_RowIndex', "name": 'DT_RowIndex', orderable: false,searchable: false,"className":"text-middle"},
                { "data": 'project_code', "name": 'project_code',"className":"text-middle"},
                { "data": 'project_name', "name": 'project_name',"className":"text-middle"},
                { "data": 'company_name', "name": 'company_name',"className":"text-middle"},
                { "data": 'created_at', "name": 'created_at',"className":"text-middle"},
                {"data": 'option', "name": 'option', orderable:false, searchable:false,"className":"text-middle"},
            ]
        })
</script>
@endpush