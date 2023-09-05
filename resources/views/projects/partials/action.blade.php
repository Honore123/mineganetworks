<button type="button" class="btn btn-outline-primary py-2 dropdown-toggle" data-toggle="dropdown">Option</button>
<div class="dropdown-menu">
<a class="dropdown-item py-2" href="{{route('projects.show',$id)}}">View project</a>
<a class="dropdown-item py-2" href="{{route('risk-management.index',$id)}}">Issues</a>
<button class="dropdown-item py-2" onclick="editProjectInfo({{$id}})">Edit</button>
<div class="dropdown-divider"></div>
<form action="{{route('project.delete', $id)}}" id="delete-project-{{$id}}" method="POST">
    @csrf
    @method('DELETE')
</form>
<button class="dropdown-item" onclick="deleteAlert({{$id}},'{{$project_name}}')">Delete</button>
</div> 