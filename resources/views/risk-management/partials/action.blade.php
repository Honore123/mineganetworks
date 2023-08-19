<button type="button" class="btn btn-outline-primary py-2 dropdown-toggle" data-toggle="dropdown">Option</button>
<div class="dropdown-menu">
@if($solution)
<button class="dropdown-item disabled">No action</button>
@endif
@if(!$solution)
<button class="dropdown-item py-2" onclick="issueResolved({{$id}})">Resolved</button>
<button class="dropdown-item py-2" onclick="editProjectRisk({{$id}})" >Edit</button>
<div class="dropdown-divider"></div>
<form action="{{route('risk-management.delete', $id)}}" id="delete-risk-project-{{$id}}" method="POST">
    @csrf
    @method('DELETE')
</form>
<button class="dropdown-item" onclick="deleteAlert({{$id}},'{{$risk['risk_name']}}')">Delete</button>
@endif
</div> 