<button type="button" class="btn btn-outline-primary py-2 dropdown-toggle" data-toggle="dropdown">Option</button>
<div class="dropdown-menu">
<a class="dropdown-item" href="{{route('risk-management.index',$id)}}">Risks</a>
<button class="dropdown-item" onclick="showModal({{$id}})">Edit</button>
<div class="dropdown-divider"></div>
<form action="{{route('project.delete', $id)}}" id="delete-project-{{$id}}" method="POST">
    @csrf
    @method('DELETE')
</form>
<button class="dropdown-item" onclick="deleteAlert({{$id}},'{{$project_name}}')">Delete</button>
</div> 