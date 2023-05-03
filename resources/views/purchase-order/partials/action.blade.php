<button type="button" class="btn btn-outline-primary py-2 dropdown-toggle" data-toggle="dropdown">Option</button>
<div class="dropdown-menu">
<a class="dropdown-item" href="{{route('purchase-order.items',$id)}}">Edit</a>
<div class="dropdown-divider"></div>
<form action="{{route('purchase-order.delete',$id)}}" method="POST" id="delete-purchase-order-{{$id}}">
    @csrf
    @method('DELETE')
</form>
<button onclick="deleteAlert({{$id}},'{{$vendor['vendor_name']}}')" class="dropdown-item">Delete</button>
</div> 