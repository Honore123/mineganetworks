<div class="modal fade" id="risk_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="forms-sample" action="{{route('risk-management.store',$project->id)}}" id="edit_risk_project" method="post">
          @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit issue</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="">Risk/Query</label>
               <select name="risk_id" class="item_selector" style="width: 100%" id="edit_risk_id">
                <option value="" disabled>~~SELECT RISK~~</option>
                @forelse($risks as $risk)
                <option value="{{$risk->id}}">{{$risk->risk_name}}</option>
                @empty
                <option value="" disabled>No risk</option>
                @endforelse
               </select>
            </div> 
          <div class="form-group">
              <label for="">Reportee</label>
              <input type="text" class="form-control" name="reportee" id="edit_reportee" placeholder="Reportee name">
          </div> 
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-outline-danger rounded-0" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary rounded-0">Update</button>
        </div>
      </div>
    </form>
    </div>
  </div>