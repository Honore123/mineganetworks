<div class="modal fade" id="record_payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Record payment for this invoice</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form class="forms-sample" action="" method="POST" id="record_payment_form">
          @csrf
          @method('PUT')
          <input type="hidden" value="2" name="status">
        <div class="modal-body">
          <div class="form-group">
            <label for="quantity">Payment date</label>
            <input type="text" class="form-control" id="record_payment_date" name="record_payment_date">
          </div>
          <div class="form-group">
            <label for="quantity">Amount</label>
            <input type="text" class="form-control" id="record_amount" name="amount" placeholder="Amount" readonly>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-outline-danger rounded-0" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary rounded-0">Submit</button>
        </div>
      </form>
      </div>
    </div>
</div>