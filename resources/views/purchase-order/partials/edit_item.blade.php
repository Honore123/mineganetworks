<div class="modal fade" id="edit_item_{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Item {{$item->product->product_name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form class="forms-sample" action="{{route('purchase-order-product.update',$item->id)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="form-group">
              <label for="select item">Item</label>
              <select class="item_selector" style="width: 100%" name="product_id" id="edit_product_{{$item->id}}">
                <option value="">Select Item</option>
                @forelse ($products as $product)
                  <option value="{{$product->id}}" {{$item->product->id == $product->id ? 'selected':''}}>{{ $product->product_name}}</option>
                @empty
                  <option value="" disabled>No products</option>
                @endforelse
              </select>
          </div>
          <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control" oninput="editTotalPrice({{$item->id}})" id="edit_quantity_{{$item->id}}" name="quantity" placeholder="Quantity" value="{{$item->quantity}}">
          </div>
          <div class="form-group">
            <label for="quantity">Unit Price</label>
            <input type="number" class="form-control" oninput="editTotalPrice({{$item->id}})" id="edit_unit_price_{{$item->id}}" name="unit_price" placeholder="Unit price" value={{$item->unit_price}}>
          </div>
          <div class="form-group">
            <label for="quantity">Total Price</label>
            <input type="number" class="form-control" id="edit_total_price_{{$item->id}}" name="total_price" placeholder="Total price" value="{{$item->total_price}}" readonly>
          </div>
        </div>
      <div class="modal-footer d-flex justify-content-between">
        <button type="button" class="btn btn-outline-danger rounded-0" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary rounded-0">Update Item</button>
      </div>
    </form>
    </div>
  </div>
</div>