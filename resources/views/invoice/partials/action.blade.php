<button type="button" class="btn btn-outline-primary py-2 dropdown-toggle" data-toggle="dropdown">Option</button>
<div class="dropdown-menu">
<a class="dropdown-item" href="{{route('invoiceItem.index',$id)}}">Edit</a>
<div class="dropdown-divider"></div>
<form action="{{route('invoice.delete',$id)}}" method="POST" id="delete-invoice-{{$id}}">
    @csrf
    @method('DELETE')
</form>
<button onclick="deleteAlert({{$id}},'{{$company_name}}')" class="dropdown-item">Delete</button>
</div> 