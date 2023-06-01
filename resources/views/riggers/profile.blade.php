@extends('layouts.app')
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
           </div>
           <div class="row mt-4">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Document Type</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($documents as $document)
                            <tr>
                                <td>{{$loop->iteration++}}</td>
                                <td>{{$document->document_type}}</td>
                                <td>
                                    <button type="button" class="btn btn-outline-primary py-2 dropdown-toggle" data-toggle="dropdown">Option</button>
                                    <div class="dropdown-menu">
                                    <a href="{{asset('storage/public/riggers/'.$rigger->name.'/'.$document->document)}}" target="blank" class="dropdown-item py-2">Download</a>
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
    </script>
@endpush