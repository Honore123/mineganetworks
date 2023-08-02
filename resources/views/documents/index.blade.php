@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>Documents</h3>
        </div>
        <div class="col-md-12 d-flex justify-content-end">
            <a class="btn btn-primary rounded-0" data-toggle="modal" data-target="#upload_document">Upload document</a>
        </div>
        @include('documents.partials.add')
        <div class="col-md-12 mt-3">
            @include('layouts.partials.notification')
        </div>
        @include('documents.partials.edit')
        <div class="col-md-12 mt-4 bg-white p-3">
            <table class="table table-hover" id="documents-table" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Size</th>
                        <th>CreatedAt</th>
                        <th>ModifiedAt</th>
                        <th>Options</th>
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
                text:'Are you sure? you want to delete '+ name + ' file.',
                icon: 'warning',
                confirmButtonText: 'Yes',
                cancelButtonText:'No',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-document-'+ id).submit();
                }
            });
        }
        function showModal(id){
            const documents = @json($documents);
            let doc = documents.find(doc=> doc.id == id);
            $("#edit_name").val(doc.name);
            $('#edit_document_form').attr("action","{{route('document.index')}}/"+id)
            $('#edit_document').modal('show');
       }
        $('#documents-table').DataTable({
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
                "url": "{{route('document.index')}}",
                "type": 'GET',
            },
            "columns": [
                { "data": 'name', "name": 'name',"className":"text-middle"},
                { "data": 'file_type', "name": 'file_type',"className":"text-middle"},
                { "data": 'file_size', "name": 'file_size',"className":"text-middle"},
                { "data": 'created_at', "name": 'created_at',"className":"text-middle"},
                { "data": 'updated_at', "name": 'updated_at',"className":"text-middle"},
                {"data": 'option', "name": 'option', orderable:false, searchable:false,"className":"text-middle"},
            ]
        })
</script>
@endpush