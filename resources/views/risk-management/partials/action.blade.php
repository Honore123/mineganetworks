<button type="button" class="btn btn-outline-primary py-2 dropdown-toggle" data-toggle="dropdown">Option</button>
<div class="dropdown-menu">
<button class="dropdown-item" >Edit</button>
<div class="dropdown-divider"></div>
<form action="{{route('risk-management.delete', $id)}}" id="delete-risk-project-{{$id}}" method="POST">
    @csrf
    @method('DELETE')
</form>
<button class="dropdown-item" onclick="deleteAlert({{$id}},'{{$risk['risk_name']}}')">Delete</button>
</div> 