<button type="button" class="btn btn-outline-primary py-2 dropdown-toggle" data-toggle="dropdown">Option</button>
<div class="dropdown-menu">
<a target="blank" href="{{asset('storage/public/customer_POs/'.$po_document)}}" class="dropdown-item py-2" >Download file</a>
@if($status !=3)
<button class="dropdown-item py-2" onclick="showModal({{$id}})">Edit</button>
<div class="dropdown-divider"></div>
<form action="{{route('customer-po.delete', $id)}}" id="delete-customer-po-{{$id}}" method="POST">
    @csrf
    @method('DELETE')
</form>
<button class="dropdown-item" onclick="deleteAlert({{$id}},'{{$po_number}}')">Delete</button>
@endif
</div> 