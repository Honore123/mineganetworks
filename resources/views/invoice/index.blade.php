@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 d-flex flex-wrap justify-content-between">
            <h3>All Invoices</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">Manage invoices</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-12">
            @include('layouts.partials.notification')
        </div>
        <div class="col-md-12 mt-4 bg-white p-3">
            <div class="mt-3 mb-4 d-flex justify-content-end">
                <a class="btn btn-primary rounded-0" href="{{route('invoice.add')}}">New Invoice</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="quotations-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice ID</th>
                            <th>Company / Individual</th>
                            <th>Project Name</th>
                            <th>Created date</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>
                </table>
            </div>
        </div>
        @include('invoice.partials.edit_invoice_info')
    </div>
@endsection
@push('scripts')
@push('scripts')
    <script>
        function editInvoiceInfo(id){
            const invoices = @json($invoices);
            const invoice = invoices.find(invoice => invoice.id == id);
            if(invoice.client_id != 0) {
                $('#customer_type option[value="1"]').prop('selected', true);
                $('#selected_client option[value="'+invoice.client_id+'"]').prop('selected', true);
                $('#tin_number').val(invoice.tin_number);
                $('#address').val(invoice.address);
                $('#project_title').val(invoice.project_title);
                customerType(document.getElementById('customer_type'));
            } else {
                $('#customer_type option[value="2"]').prop('selected', true);
                $('#company_name').val(invoice.company_name);
                $('#tin_number').val(invoice.tin_number);
                $('#address').val(invoice.address);
                $('#project_title').val(invoice.project_title);
                customerType(document.getElementById('customer_type'));
            }
            $('#edit_invoice_info').modal('show');
            $("#edit_quotation_title_modal").text("Edit "+invoice.company_name+"'s invoice");
            var url = '{{ route("invoice.update", ":id") }}';
            url = url.replace(':id',id);
            $('#edit_invoice_form').attr('action',url);
        }
        function customerType(sel){
            const customer_type = sel.value;
            if(customer_type == 1) {
            $('#company_name_form_group').addClass('d-none');
            $('#customer_form_group').removeClass('d-none');
            $('#tin_number_form_group').addClass('d-none');
            $('#address_form_group').addClass('d-none');
            $('#submit_btn').removeClass('d-none');
            $('#project_title_form_group').removeClass('d-none');
            } else if(customer_type == 2) {
            $('#company_name_form_group').removeClass('d-none');
            $('#customer_form_group').addClass('d-none');
            $('#tin_number_form_group').removeClass('d-none');
            $('#address_form_group').removeClass('d-none');
            $('#submit_btn').removeClass('d-none');
            $('#project_title_form_group').removeClass('d-none');
            } else {
            $('#company_name_form_group').addClass('d-none');
            $('#customer_form_group').addClass('d-none');
            $('#tin_number_form_group').addClass('d-none');
            $('#address_form_group').addClass('d-none');
            $('#project_title_form_group').addClass('d-none')
            $('#submit_btn').addClass('d-none');
            }
        }
        function deleteAlert(id, name){
            swal.fire( {
                title:'Confirmation',
                text:'Do you want to delete ' + name+"'s invoice? All item in this invoice will also be delete.",
                icon: 'warning',
                confirmButtonText: 'Yes',
                cancelButtonText:'No',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-invoice-'+ id).submit();
                }
            });
        }
         $('#quotations-table').DataTable({
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
                "url": "{{route('invoice.index')}}",
                "type": 'GET',
            },
            "columns": [
                {"data": 'DT_RowIndex', "name": 'DT_RowIndex', orderable: false,searchable: false,"className":"text-middle"},
                { "data": 'invoice_code', "name": 'invoice_code'},
                { "data": 'company_name', "name": 'company_name',"className":"text-middle"},
                { "data": 'project_title', "name": 'project_title',"className":"text-middle"},
                { "data": 'date', "name": 'date',"className":"text-middle"},
                {"data": 'option', "name": 'option', orderable:false, searchable:false,"className":"text-middle"},
            ]
        })
    </script>
@endpush