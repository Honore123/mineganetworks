<button type="button" class="btn btn-outline-primary py-2 dropdown-toggle" data-toggle="dropdown">Option</button>
<div class="dropdown-menu">
@if($status != 0 && $status != 2)
    <form action="{{route('invoice.status',$id)}}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" value="2" name="status">
        <button class="dropdown-item py-2">Paid</button>
    </form>
   
    <a class="dropdown-item py-2" href="{{route('invoiceItem.index',$id)}}">Add items</a>
    <button class="dropdown-item py-2" onclick="editInvoiceInfo({{$id}})" >Edit invoice</button>
    <div class="dropdown-divider"></div>
    <form action="{{route('invoice.status',$id)}}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" value="0" name="status">
        <button class="dropdown-item py-2">Cancel</button>
    </form>
    <div class="dropdown-divider"></div>
@endif
@if($status == 0 || $status == 2)
<a class="dropdown-item py-2" href="{{route('invoiceItem.index',$id)}}">View invoice</a>
@endif
@if($status != 2)

<form action="{{route('invoice.delete',$id)}}" method="POST" id="delete-invoice-{{$id}}">
    @csrf
    @method('DELETE')
</form>
<button onclick="deleteAlert({{$id}},'{{$company_name}}')" class="dropdown-item">Delete</button>
@endif
</div> 