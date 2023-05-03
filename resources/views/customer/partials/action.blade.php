<button type="button" class="btn btn-outline-primary py-2 dropdown-toggle" data-toggle="dropdown">Option</button>
<div class="dropdown-menu">
<a class="dropdown-item" href="{{route('pricing-book.index',$id)}}">Pricing Book</a>
<button class="dropdown-item" onclick="showModal({{$id}})">Edit</button>
<div class="dropdown-divider"></div>
<form action="{{route('customer.delete', $id)}}" id="delete-customer-{{$id}}" method="POST">
    @csrf
    @method('DELETE')
</form>
<button class="dropdown-item" onclick="deleteAlert({{$id}},'{{$customer_name}}')">Delete</button>
</div> 