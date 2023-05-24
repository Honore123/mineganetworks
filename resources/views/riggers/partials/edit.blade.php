<div class="modal fade" id="edit_rigger" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="forms-sample" id="edit_rigger_form" method="post">
          @csrf
          @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Rigger</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
              <label for="">Names</label>
              <input type="text" class="form-control" name="name" id="edit_name" placeholder="First and Last Name">
          </div>
          <div class="form-group">
            <label for="email">Phone Number</label>
            <input type="number" class="form-control" id="edit_phone" name="phone" placeholder="Phone number">
          </div>
          <div class="form-group">
            <label for="email">ID Number</label>
            <input type="number" class="form-control" id="edit_nid" name="nid" placeholder="ID number">
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