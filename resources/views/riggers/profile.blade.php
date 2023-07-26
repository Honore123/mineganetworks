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
        @include('layouts.partials.notification')
    </div>
    <div class="col-md-12 card">
        <div class="card-body">
            <h3 class="card-title">Rigger profile</h3>
           <div class="row mt-5">
            <div class="col-md-6">
                <p class="font-weight-bold" for="">Names: <span class="font-weight-normal">{{$rigger->name}}</span></p>
                <p class="font-weight-bold my-3" for="">NID Number: <span class="font-weight-normal">{{$rigger->nid}}</span></p>
                <p class="font-weight-bold" for="">Phone number: <span class="font-weight-normal">{{$rigger->phone}}</span></p>
            </div>
           </div>
           <div class="row mx-0 mt-5 justify-content-between">
                <h3 class="card-title">Documents</h3>
                <button class="btn btn-primary rounded-0" data-toggle="modal" data-target="#document_rigger">New document</button>
                @include('riggers.partials.document')
                @include('riggers.partials.edit_document')
           </div>
           <div class="row mt-4">
                <div class="col-md-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Document Type</th>
                                <th>Status</th>
                                <th>Issued date</th>
                                <th>Expiry date</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($documents as $document)
                            <tr>
                                <td>{{$loop->iteration++}}</td>
                                <td>{{$document->document_type}}</td>
                                <td>
                                    @if(is_null($document->expiry_date))
                                    <span class="badge badge-primary">Life time</span>
                                    @elseif(new DateTime($document->expiry_date)  >= new DateTime('today'))
                                    <span class="badge badge-success">Valid</span>
                                    @else
                                    <span class="badge badge-danger">Expired</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!is_null($document->issued_date))
                                    {{$document->issued_date}}
                                    @else
                                    Not applicable
                                    @endif
                                </td>
                                <td>
                                    @if(!is_null($document->expiry_date))
                                    {{$document->expiry_date}}
                                    @else
                                    Not applicable
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-primary py-2 dropdown-toggle" data-toggle="dropdown">Option</button>
                                    <div class="dropdown-menu">
                                    <a href="{{asset('storage/public/riggers/'.$rigger->name.'/'.$document->document)}}" target="blank" class="dropdown-item py-2">Download</a>
                                    <button onclick="showModal({{$document->id}})"  class="dropdown-item py-2">Edit Document</button>
                                    <div class="dropdown-divider"></div>
                                    <form action="{{route('rigger-document.delete',[$rigger->id,$document->id])}}" id="delete-rigger-document-{{$document->id}}"  method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button class="dropdown-item py-2" onclick="deleteAlert({{$document->id}}, '{{$document->document_type}}')">Remove</button>
                                    </div> 
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">No documents</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
           </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        function deleteAlert(id, name){
            swal.fire( {
                title:'Confirmation',
                text:'Are you sure you want to delete this ' + name,
                icon: 'warning',
                confirmButtonText: 'Yes',
                cancelButtonText:'No',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-rigger-document-'+ id).submit();
                }
            });
        }
        function showModal(id){
        const documents = @json($documents);
        let document = documents.find(document=> document.id == id);
        $("#edit_document_type").val(document.document_type);
        $("#edit_issued_date").val(document.issued_date);
        $("#edit_expiry_date").val(document.expiry_date);
        var url = '{{ route("rigger.update.doc", ":id") }}';
        url = url.replace(':id',id);
        $('#edit_rigger_doc_form').attr("action",url);
        $('#edit_document_rigger').modal('show');
       }
    </script>
@endpush