<div class="modal fade" id="edit_item_{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Item {{$item->product->product_name}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form class="forms-sample" action="{{route('quotation-product.update',[$item->id,$quotation->id])}}" method="POST">
          @csrf
          @method('PUT')
        <div class="modal-body">
          @if ($quotation->client_id != 0)
          <div class="form-group">
            <label for="exampleInputUsername1">Source</label>
            <select name="item_source" id="item_source" onchange="editSetSource(this,{{$item->id}})" class="form-control">
              <option value="" disabled>~~Choose Source~~</option>
              <option value="0" {{$quotation->client_id == 0 ? 'selected':''}}>Products</option>
              <option value="{{$quotation->client_id}}" {{$quotation->client_id != 0 ? 'selected':''}}>Pricing book</option>
            </select>
          </div>
          @endif
          <div class="form-group">
              <label for="select item">Item</label>
              <select class="edit_item_selector" style="width: 100%" name="product_id" id="edit_product_{{$item->id}}">
                <option value="">Select Item</option>
                @forelse ($products as $product)
                  <option value="{{$quotation->client_id != 0 ? $product->product->id : $product->id}}" {{$quotation->client_id != 0 ? ($product->product->id == $item->product->id ? 'selected':'') :( $product->id == $item->product->id ? 'selected' : '')}}>{{$quotation->client_id != 0 ? $product->product->product_name : $product->product_name}}</option>
                
                @empty
                  <option value="" disabled>No products</option>
                @endforelse
                
              </select>
            </div>
          <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value={{$item->quantity}} step=".001" placeholder="Quantity">
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