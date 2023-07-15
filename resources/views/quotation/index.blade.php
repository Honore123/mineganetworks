@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>All Quotations</h3>
        </div>
        <div class="col-md-12">
            @include('layouts.partials.notification')
        </div>
        <div class="col-md-12 d-flex justify-content-end">
            <a class="btn btn-primary rounded-0" href="{{route('quotation.add')}}">New Quotation</a>
        </div>
        <div class="col-md-12 mt-4 bg-white p-3">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="quotations-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Quotation ID</th>
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
    </div>
@endsection
@push('scripts')
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
                { "data": 'client_name', "name": 'client_name',"className":"text-middle"},
                { "data": 'project_title', "name": 'project_title',"className":"text-middle"},
                { "data": 'date', "name": 'date',"className":"text-middle"},
                {"data": 'option', "name": 'option', orderable:false, searchable:false,"className":"text-middle"},
            ]
        })
    </script>
@endpush