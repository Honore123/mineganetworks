@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>Product Sub-categories</h3>
        </div>
        @include('subcategory.partials.add_subcategory')
        <div class="col-md-12 mt-3">
            @include('layouts.partials.notification')
        </div>
        <div class="col-md-6 mt-4 bg-white p-3">
            <div class="d-flex justify-content-end">
                <a class="btn btn-primary rounded-0 mr-4 mb-4" data-toggle="modal" data-target="#new_subcategory">New Sub-category</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-stripped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subcategories as $subcategory)
                        <tr>
                            <td>{{$loop->iteration++}}</td>
                            <td>{{$subcategory->sub_name}}</td>
                            <td>
                                <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown">Option</button>
                                <div class="dropdown-menu">
                                <a class="dropdown-item">Edit</a>
                                <div class="dropdown-divider"></div>
                                <form action="" id="delete-subcategory-{{$subcategory->id}}" method="POST">
                                  
                                </form>
                                <button class="dropdown-item" onclick="deleteAlert({{$subcategory->id}},'{{$subcategory->sub_name}}')">Delete</button>
                                </div> 
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="7">No units yet!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function deleteAlert(id, name){
            swal.fire( {
                title:'Confirmation',
                text:'Do you want to delete ' + name,
                icon: 'warning',
                confirmButtonText: 'Yes',
                cancelButtonText:'No',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-subcategory-'+ id).submit();
                }
            });
        }
</script>
@endpush