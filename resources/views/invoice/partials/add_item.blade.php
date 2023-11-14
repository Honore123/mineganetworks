<div class="modal fade" id="add_item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form class="forms-sample" action="{{route('invoiceItem.store', $invoice->id)}}" method="POST">
          @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="quantity">Item name</label>
            <input type="text" class="form-control" id="item_name" name="item_name" placeholder="Item name">
          </div>
          <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control" oninput="totalPrice()" id="quantity" name="quantity" placeholder="Quantity">
          </div>
          <div class="form-group">
            <label for="unit_price">Unit price</label>
            <input type="number" class="form-control" oninput="totalPrice()" id="unit_price" name="unit_price" placeholder="Unit price">
          </div>
          <div class="form-group">
            <label for="total_price">Total price</label>
            <input type="number" class="form-control" id="total_price" name="total_price" placeholder="Total price" readonly>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-outline-danger rounded-0" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary rounded-0">Add Item</button>
        </div>
      </form>
      </div>
    </div>
</div>