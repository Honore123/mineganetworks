<div class="col-md-12 mt-2 d-flex justify-content-between">
    <h5>Acceptance documents</h5>
    <button class="btn btn-primary rounded-0" data-toggle="modal" data-target="#acceptance_add">New acceptance</button>
    @include('projects.partials.acceptance.partials.create')
  
</div>
<div class="col-md-12 mt-3">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>P.O number</th>
                <th>Uploaded date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($acceptances as $acceptance)
            <tr>
                <td>{{$loop->iteration ++}}</td>
                <td>{{$acceptance->purchase['po_number']}}</td>
                <td>{{$acceptance->created_at->format('d-m-Y')}}</td>
                <td>
                    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown">Option</button>
                    <div class="dropdown-menu">
                        <a href="{{asset('storage/public/acceptance/'.$acceptance->acceptance_document)}}" target="blank" class="dropdown-item py-2">Download</a>
                        <button class="dropdown-item py-2" onclick="editAcceptance({{$acceptance->id}})" data-toggle="modal" data-target="#acceptance_edit_{{$acceptance->id}}">Edit</button>
                        <div class="dropdown-divider"></div>
                        <form action="{{route('acceptance.delete',$acceptance->id)}}" method="POST" id="delete_acceptance_form_{{$acceptance->id}}">
                            @csrf
                            @method('DELETE')
                        </form>
                        <button class="dropdown-item" onclick="deleteAcceptance({{$acceptance->id}},'{{$acceptance->purchase['po_number']}}')">Delete</button>
                    </div> 
                </td>
                @include('projects.partials.acceptance.partials.edit')
            </tr>
            @empty
            <tr>
                <td class="text-center" colspan="4">No acceptance yet</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>