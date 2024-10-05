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
        <div class="col-md-12 d-flex flex-wrap justify-content-between">
            <h3>All Quotations</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">Manage quotations</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-12">
            @include('layouts.partials.notification')
        </div>
       
        <div class="col-md-12 mt-4 bg-white p-3">
            <div class="mt-3 mb-4 d-flex justify-content-end">
                <a class="btn btn-primary rounded-0" href="{{route('quotation.add')}}">New Quotation</a>
            </div>
            <table class="table table-bordered table-striped table-hover table-responsive" id="quotations-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Quotation ID</th>
                        <th>Company</th>
                        <th>Project name</th>
                        <th>Quotation title</th>
                        <th>Total Incl. VAT</th>
                        <th>Created date</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
        @include('quotation.partials.edit_customer_info')
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
       
        function editCustomerInfo(id){
            const quotations = @json($quotations);
            const quotation = quotations.find(quotation => quotation.id == id);
            $('#selected_project option[value=""]').prop('selected', true);
            if(quotation.client_id != 0) {
                $('#customer_type option[value="1"]').prop('selected', true);
                $('#selected_client option[value="'+quotation.client_id+'"]').prop('selected', true);
                $('#project_title').val(quotation.project_title);
                customerType(document.getElementById('customer_type'));
            } else {
                $('#customer_type option[value="2"]').prop('selected', true);
                $('#client_name').val(quotation.client_name);
                $('#project_title').val(quotation.project_title);
                customerType(document.getElementById('customer_type'));
            }
            $('#selected_project option[value="'+quotation.project_id+'"]').prop('selected', true);
            $('#selected_project').select2();
            $('#edit_customer_info').modal('show');
            $("#edit_quotation_title_modal").text("Edit "+quotation.client_name+"'s quotation");
            var url = '{{ route("quotation.update", ":id") }}';
            url = url.replace(':id',id);
            $('#edit_quotation_form').attr('action',url);
        }
        function customerType(sel){
        const customer_type = sel.value;
        
        if(customer_type == 1) {
          $('#customer_form_group').removeClass('d-none');
          $('#client_form_group').addClass('d-none');
          $('#project_form_group').removeClass('d-none');
          $('#title_form_group').removeClass('d-none');
          $('#submit_btn').removeClass('d-none');
        } else if(customer_type == 2) {
          $('#client_form_group').removeClass('d-none');
          $('#customer_form_group').addClass('d-none');
          $('#project_form_group').removeClass('d-none');
          $('#title_form_group').removeClass('d-none');
          $('#submit_btn').removeClass('d-none');
        } else {
          $('#customer_form_group').addClass('d-none');
          $('#client_form_group').addClass('d-none');
          $('#project_form_group').addClass('d-none');
          $('#title_form_group').addClass('d-none');
          $('#submit_btn').addClass('d-none');
        }
      }
        function deleteAlert(id, name){
            swal.fire( {
                title:'Confirmation',
                text:'Do you want to delete ' + name+"'s quotation? All item in this quotation will also be delete.",
                icon: 'warning',
                confirmButtonText: 'Yes',
                cancelButtonText:'No',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-quotation-'+ id).submit();
                }
            });
        }
         $('#quotations-table').DataTable({
            'dom':'lBfrtip',
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
                "url": "{{route('quotation.index')}}",
                "type": 'GET',
            },
            "columns": [
                {"data": 'DT_RowIndex', "name": 'DT_RowIndex', orderable: false,searchable: false,"className":"text-middle"},
                { "data": 'quotation_code', "name": 'quotation_code'},
                { "data": 'client_name', "name": 'client_name',"className":"w-25"},
                { "data": 'project.project_name', "name": 'project.project_name',"defaultContent":"-","className":"text-middle w-25"},
                { "data": 'project_title', "name": 'project_title',"className":"w-25"},
                { "data": 'total_inc_vat', "name": 'total_inc_vat',"className":"text-middle"},
                { "data": 'date', "name": 'date',"className":"text-middle"},
                {"data": 'option', "name": 'option', orderable:false, searchable:false,"className":"text-middle"},
            ],
            "buttons": [
                {extend: 'colvis', className: 'btn btn-warning', columns: ':visible'},
                { extend: 'excelHtml5', className: 'btn btn-info', exportOptions: {columns:':visible'} },
            ],
        })
    </script>
@endpush