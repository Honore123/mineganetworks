<div class="modal fade" id="risk_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="forms-sample"  id="edit_risk_project" method="post">
          @csrf
          @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit issue</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
              <div class="form-group">
                  <label for="">Issue</label>
                <select name="risk_id" class="item_selector" style="width: 100%" id="edit_risk_id">
                  <option value="" disabled>~~SELECT ISSUE~~</option>
                  @forelse($risks as $risk)
                  <option value="{{$risk->id}}">{{$risk->risk_name}}</option>
                  @empty
                  <option value="" disabled>No issue</option>
                  @endforelse
                </select>
              </div> 
              <div class="form-group">
                <label for="datetimepicker">Select Date and Time:</label>
                <input type="text" class="form-control" id="edit_datetimepicker" id="reported_at" name="reported_at" />
            </div>
            <div class="form-group">
                <label for="">Reporter</label>
                <input type="text" class="form-control" name="reportee" id="edit_reportee" placeholder="Reporter name">
            </div> 
            <div class="form-group">
              <label for="">Assigned to</label>
              <input type="text" class="form-control" name="assigned_to" id="edit_assigned_to" placeholder="Assignee name">
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