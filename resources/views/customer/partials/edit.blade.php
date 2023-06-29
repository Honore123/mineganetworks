<div class="modal fade" id="edit_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="forms-sample" id="edit_customer_form" method="post">
          @csrf
          @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="edit_modal_header">Edit Customer</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
              <label for="">Customer Name</label>
              <input type="text" class="form-control" name="customer_name" id="edit_customer_name" placeholder="Customer name">
          </div>
          <div class="form-group">
            <label for="">Email</label>
            <input type="email" class="form-control" name="email" id="edit_email" placeholder="Customer email">
          </div>
          <div class="form-group">
            <label for="">Phone Number</label>
            <input type="number" class="form-control" name="phone_number" id="edit_phone_number" placeholder="Phone number">
          </div>
          <div class="form-group">
            <label for="">Address</label>
            <input type="text" class="form-control" name="address" id="edit_address" placeholder="Ex: Street, City, Province">
          </div>
          <div class="form-group">
            <label for="">TIN</label>
            <input type="number" class="form-control" name="tin" id="edit_tin" placeholder="TIN">
          </div>
          <div class="form-group">
            <label for="price">Contract start date</label>
            <input type="date" class="form-control" id="edit_start_date" name="start_date" placeholder="Start date">
          </div>
          <div class="form-group">
            <label for="price">Contract end date</label>
            <input type="date" class="form-control" id="edit_end_date" name="end_date" placeholder="End date">
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