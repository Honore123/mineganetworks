<div class="modal fade" id="risk_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="forms-sample" method="post" id="edit_risk_form">
          @csrf
          @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Issue</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
              <label for="">name</label>
              <input type="text" class="form-control" name="risk_name" id="edit_risk_name" placeholder="Risk name">
          </div> 
          <div class="form-group">
            <label for="Description">Description</label>
            <textarea class="form-control" name="risk_description" id="edit_risk_description" cols="30" rows="10" placeholder="Issue description"></textarea>
          </div>
          <div class="form-group">
            <label for="">Severity</label>
            <select type="text" class="form-control" name="risk_severity" id="risk_severity">
              <option value="" disabled>~~SELECT SEVERITY</option>
              <option value="Low">Low</option>
              <option value="Medium">Medium</option>
              <option value="High">High</option>
            </select>
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