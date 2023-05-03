<div class="modal fade" id="new_vendor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="forms-sample" action="{{route('vendor.store')}}" method="post">
          @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Vendor</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
              <label for="">Vendor Name</label>
              <input type="text" class="form-control" name="vendor_name" id="vendor_name" placeholder="Vendor name">
          </div>
          <div class="form-group">
            <label for="price">Contract start date</label>
            <input type="date" class="form-control" id="start_date" name="start_date" placeholder="Start date">
          </div>
          <div class="form-group">
            <label for="price">Contract end date</label>
            <input type="date" class="form-control" id="end_date" name="end_date" placeholder="End date">
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