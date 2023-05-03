<div class="modal fade" id="add_item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form class="forms-sample" action="{{route('purchase-order-product.store',$purchaseOrder->id)}}" method="POST">
          @csrf
        <div class="modal-body">
          <div class="form-group">
              <label for="select item">Item</label>
              <select class="item_selector" style="width: 100%" name="product_id" id="product_id">
                <option value="">Select Item</option>
                @forelse ($products as $product)
                  <option value="{{$product->id}}">{{ $product->product_name}}</option>
                @empty
                  <option value="" disabled>No products</option>
                @endforelse
              </select>
          </div>
          <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control" oninput="totalPrice()" id="quantity" name="quantity" placeholder="Quantity">
          </div>
          <div class="form-group">
            <label for="quantity">Unit Price</label>
            <input type="number" class="form-control" oninput="totalPrice()" id="unit_price" name="unit_price" placeholder="Unit price">
          </div>
          <div class="form-group">
            <label for="quantity">Total Price</label>
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