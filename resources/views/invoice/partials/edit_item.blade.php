<div class="modal fade" id="edit_item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Item</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form class="forms-sample" method="POST" id="edit_item_form">
          @csrf
          @method('PUT')
        <div class="modal-body">
          <div class="form-group">
            <label for="quantity">Item name</label>
            <input type="text" class="form-control" id="edit_item_name" name="item_name" placeholder="Item name">
          </div>
          <div class="form-group">
            <label for="quantity">{{$invoice->invoice_type === 1 ? 'Quantity' : 'No of rigger(s)'}}</label>
            <input type="number" class="form-control" oninput="editTotalPrice({{$invoice->invoice_type}})" id="edit_quantity" name="quantity" placeholder={{$invoice->invoice_type === 1 ? 'Quantity' : 'Rigger(s)'}} step=".001">
          </div>
          <div class="form-group">
            <label for="unit_price">Unit price</label>
            <input type="number" class="form-control" oninput="editTotalPrice({{$invoice->invoice_type}})" id="edit_unit_price" name="unit_price" placeholder="Unit price">
          </div>
          @if($invoice->invoice_type === 2)
          <div class="form-group">
            <label for="rigger_days">No of day(s)</label>
            <input type="number" class="form-control" oninput="editTotalPrice({{$invoice->invoice_type}})" id="edit_rigger_days" name="rigger_days" placeholder="No of day(s)">
          </div>
          @endif
          <div class="form-group">
            <label for="total_price">Total price</label>
            <input type="number" class="form-control" id="edit_total_price" name="total_price" placeholder="Total price" readonly>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-outline-danger rounded-0" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary rounded-0">Update</button>
        </div>
      </form>
      </div>
    </div>
</div>