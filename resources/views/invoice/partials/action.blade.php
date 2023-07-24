<button type="button" class="btn btn-outline-primary py-2 dropdown-toggle" data-toggle="dropdown">Option</button>
<div class="dropdown-menu">
<a class="dropdown-item py-2" href="{{route('invoiceItem.index',$id)}}">Add items</a>
<button class="dropdown-item py-2" onclick="editInvoiceInfo({{$id}})" >Edit invoice</button>
<div class="dropdown-divider"></div>
<form action="{{route('invoice.delete',$id)}}" method="POST" id="delete-invoice-{{$id}}">
    @csrf
    @method('DELETE')
</form>
<button onclick="deleteAlert({{$id}},'{{$company_name}}')" class="dropdown-item">Delete</button>
</div> 