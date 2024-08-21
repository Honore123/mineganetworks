<div class="modal fade" id="risk_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="forms-sample" action="{{route('risk-management.store',$project->id)}}" method="post">
          @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Record Issue</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="">Issue</label>
               <select name="risk_id" class="item_selector" style="width: 100%" id="risk_id">
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
              <input type="text" class="form-control" id="datetimepicker" id="reported_at" name="reported_at" />
          </div>
          <div class="form-group">
            <label for="">Site ID</label>
            <input type="text" class="form-control" name="site_id" id="site_id" placeholder="Site ID">
        </div> 
        <div class="form-group">
          <label for="">Site name</label>
          <input type="text" class="form-control" name="site_name" id="site_name" placeholder="Site name">
      </div> 
          <div class="form-group">
              <label for="">Reporter</label>
              <input type="text" class="form-control" name="reportee" id="reportee" placeholder="Reporter name">
          </div> 
          <div class="form-group">
            <label for="">Assigned to</label>
            <input type="text" class="form-control" name="assigned_to" id="assigned_to" placeholder="Assignee name">
        </div> 
        <div class="form-group">
          <label for="">Comment</label>
          <textarea class="form-control" name="comment" id="comment" placeholder="Write here"></textarea>
      </div> 
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-outline-danger rounded-0" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary rounded-0">Save</button>
        </div>
      </div>
    </form>
    </div>
  </div>