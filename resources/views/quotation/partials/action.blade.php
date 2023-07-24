<button type="button" class="btn btn-outline-primary py-2 dropdown-toggle" data-toggle="dropdown">Option</button>
<div class="dropdown-menu">
<a class="dropdown-item py-2" href="{{route('quotation.items',$id)}}">Add Items</a>
<button class="dropdown-item py-2" onclick="editCustomerInfo({{$id}})">Edit Quotation</button>
<div class="dropdown-divider"></div>
<form action="{{route('quotation.delete',$id)}}" method="POST" id="delete-quotation-{{$id}}">
    @csrf
    @method('DELETE')
</form>
<button onclick="deleteAlert({{$id}},'{{$client_name}}')" class="dropdown-item">Delete</button>
</div> 