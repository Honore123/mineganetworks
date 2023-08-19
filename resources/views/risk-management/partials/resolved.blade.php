<div class="modal fade" id="resolved_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="forms-sample"  method="post" id="issue_resolved_form">
          @csrf
          @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Issue resolved form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label for="datetimepicker">Select Date and Time:</label>
              <input type="text" class="form-control" id="datetimepicker" id="resolved_at" name="resolved_at" value="{{old('resolved_at')}}" />
          </div>
          <div class="form-group">
              <label for="">Reporter</label>
              <textarea name="solution" id="solution" class="form-control" cols="30" rows="10" placeholder="Solution or comment">{{old('solution')}}</textarea>
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