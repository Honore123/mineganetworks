<button type="button" class="btn btn-outline-primary py-2 dropdown-toggle" data-toggle="dropdown">Option</button>
<div class="dropdown-menu">
<a class="dropdown-item" href="{{route('product.edit',$id)}}">Edit</a>
<div class="dropdown-divider"></div>
<form action="{{route('pricing-book.delete', $id)}}" id="delete-item-{{$id}}" method="POST">
    @csrf
    @method('DELETE')
</form>
<button class="dropdown-item" onclick="deleteAlert({{$id}},'{{$product['product_name']}}')">Delete</button>
</div> 