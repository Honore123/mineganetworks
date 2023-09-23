<div class="modal fade" id="acceptance_edit_{{$acceptance->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="forms-sample" action="{{route('acceptance.update',$acceptance->id)}}" method="post" enctype="multipart/form-data">
          @csrf
          @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Upload acceptance</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="">Purchase order</label>
               <select name="customer_purchase_order_id" class="item_selector" style="width: 100%" id="edit_customer_purchase_order_id_{{$acceptance->id}}">
                <option value="" selected disabled>~~SELECT P.O~~</option>
                @forelse($customerPOs as $purchaseOrder)
                <option value="{{$purchaseOrder->id}}" {{$acceptance->customer_purchase_order_id == $purchaseOrder->id ? 'selected':''}}>{{$purchaseOrder->po_number}}</option>
                @empty
                <option value="" disabled>No PO</option>
                @endforelse
               </select>
            </div>  
          <div class="form-group">
            <label for="">File</label>
            <input type="file" class="form-control" name="acceptance_document" id="acceptance_document">
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