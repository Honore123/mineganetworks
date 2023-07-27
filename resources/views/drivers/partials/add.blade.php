<div class="modal fade" id="new_driver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="forms-sample" action="{{route('drivers.store')}}" method="post">
          @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Driver</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
              <label for="">Names</label>
              <input type="text" class="form-control" name="driver_name" id="name" placeholder="First and Last Name">
          </div>
          <div class="form-group">
            <label for="email">Phone number</label>
            <input type="number" class="form-control" id="phone" name="phone_number" placeholder="Phone number">
          </div>
          <div class="form-group">
            <label for="email">Vehicle type</label>
            <input type="text" class="form-control" id="nid" name="vehicle_type" placeholder="Ex: Dina, Pickup,..">
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