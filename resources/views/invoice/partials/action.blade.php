<button type="button" class="btn btn-outline-primary py-2 dropdown-toggle" data-toggle="dropdown">Option</button>
<div class="dropdown-menu">
@if($status != 0 && $status != 2)
    <button class="dropdown-item py-2" onclick="paidInvoice({{$id}},'{{$invoice_code}}','{{$total_inc_vat}}')">Paid</button>
    <a class="dropdown-item py-2" href="{{route('invoiceItem.index',$id)}}">Add items</a>
    <button class="dropdown-item py-2" onclick="editInvoiceInfo({{$id}})" >Edit invoice</button>
    <div class="dropdown-divider"></div>
    <form action="{{route('invoice.status',$id)}}" id="update-cancel-{{$id}}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" value="0" name="status">
        
    </form>
    <button class="dropdown-item py-2" onclick="cancelInvoice({{$id}},'{{$invoice_code}}')">Cancel</button>
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