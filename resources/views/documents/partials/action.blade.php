<button type="button" class="btn btn-outline-primary py-2 dropdown-toggle" data-toggle="dropdown">Option</button>
<div class="dropdown-menu">
<button class="dropdown-item py-2" onclick="showModal({{$id}})">Edit</button>
<a href="{{asset('storage/public/documents/'.$name.'.'.$file_type)}}" target="blank" class="dropdown-item py-2">Download</a>
<div class="dropdown-divider"></div>
<form action="{{route('document.delete', $id)}}" id="delete-document-{{$id}}" method="POST">
    @csrf
    @method('DELETE')
</form>
<button class="dropdown-item" onclick="deleteAlert({{$id}},'{{$name}}')">Delete</button>
</div> 