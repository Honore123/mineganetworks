<div class="modal fade" id="edit_item_{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Item {{$item->product->product_name}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form class="forms-sample" action="{{route('quotation-product.update',$item->id)}}" method="POST">
          @csrf
          @method('PUT')
        <div class="modal-body">
          {{-- <div class="form-group">
            <label for="exampleInputUsername1">Item Category</label>
            <select name="item_category" id="item_category" class="form-control">
              <option value="">Select Category</option>
              <option value="">Goods</option>
              <option value="">Services</option>
              <option value="">Supply and Installation</option>
            </select>
          </div> --}}
          <div class="form-group">
              <label for="select item">Item</label>
              <select class="edit_item_selector" style="width: 100%" name="product_id" id="edit_product_id">
                <option value="">Select Item</option>
                @forelse ($products as $product)
                  <option value="{{$product->id}}" {{$product->id == $item->product_id ?'selected' :''}}>{{$product->product_name}}</option>
                @empty
                  <option value="" disabled>No products</option>
                @endforelse
                
              </select>
            </div>
          <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value={{$item->quantity}} placeholder="Quantity">
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