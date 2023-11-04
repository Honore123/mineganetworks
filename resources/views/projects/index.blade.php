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
            <table class="table table-bordered table-striped table-hover table-responsive" id="customers-table" style="width:100%">
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
        function editProjectInfo(id){
            const projects = @json($projects);
            const project = projects.find(project => project.id == id);
            if(project.client_id != 0) {
                $('#edit_customer_type option[value="1"]').prop('selected', true);
                $('#edit_selected_client option[value="'+project.client_id+'"]').prop('selected', true);
                $('#edit_project_name').val(project.project_name);
                EditCustomerType(document.getElementById('edit_customer_type'));
            } else {
                $('#edit_customer_type option[value="2"]').prop('selected', true);
                $('#edit_company_name').val(project.company_name);
                $('#edit_project_name').val(project.project_name);
                EditCustomerType(document.getElementById('edit_customer_type'));
            }
            $('#project_edit').modal('show');
            var url = '{{ route("project.update", ":id") }}';
            url = url.replace(':id',id);
            $('#edit_project_form').attr('action',url);
        }
        function EditCustomerType(sel){
        const customer_type = sel.value;
        if(customer_type == 1) {
          $('#edit_customer_form_group').removeClass('d-none');
          $('#edit_client_form_group').addClass('d-none');
          $('#edit_title_form_group').removeClass('d-none');
        } else if(customer_type == 2) {
          $('#edit_client_form_group').removeClass('d-none');
          $('#edit_customer_form_group').addClass('d-none');
          $('#edit_title_form_group').removeClass('d-none');
        } else {
          $('#edit_customer_form_group').addClass('d-none');
          $('#edit_client_form_group').addClass('d-none');
          $('#edit_title_form_group').addClass('d-none');
        }
      }
    function customerType(sel){
        const customer_type = sel.value;
        if(customer_type == 1) {
          $('#customer_form_group').removeClass('d-none');
          $('#client_form_group').addClass('d-none');
          $('#title_form_group').removeClass('d-none');
        } else if(customer_type == 2) {
          $('#client_form_group').removeClass('d-none');
          $('#customer_form_group').addClass('d-none');
          $('#title_form_group').removeClass('d-none');
        } else {
          $('#customer_form_group').addClass('d-none');
          $('#client_form_group').addClass('d-none');
          $('#title_form_group').addClass('d-none');
        }
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
                { "data": 'project_name', "name": 'project_name',"className":"w-50"},
                { "data": 'company_name', "name": 'company_name',"className":"text-middle w-25"},
                { "data": 'created_at', "name": 'created_at',"className":"text-middle"},
                {"data": 'option', "name": 'option', orderable:false, searchable:false,"className":"text-middle"},
            ]
        })
</script>
@endpush