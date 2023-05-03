<button type="button" class="btn btn-outline-primary py-2 dropdown-toggle" data-toggle="dropdown">Option</button>
<div class="dropdown-menu">
<a class="dropdown-item" href="{{route('pricing-book.index',$id)}}">Pricing Book</a>
<button class="dropdown-item" onclick="showModal({{$id}})">Edit</button>
<div class="dropdown-divider"></div>
<form action="{{route('vendor.delete', $id)}}" id="delete-vendor-{{$id}}" method="POST">
    @csrf
    @method('DELETE')
</form>
<button class="dropdown-item" onclick="deleteAlert({{$id}},'{{$vendor_name}}')">Delete</button>
</div> 