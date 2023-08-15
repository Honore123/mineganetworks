<div class="modal fade" id="edit_invoice_info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="forms-sample" id="edit_invoice_form" action="" method="post">
          @csrf
          @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="edit_quotation_title_modal">Edit invoice</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="exampleInputName1">Client type</label>
                <select name="customer_type" id="customer_type" onchange="customerType(this)" class="form-control">
                  <option value="0">~~Select Client type~~</option>
                  @forelse ($types as $type)
                    <option value="{{$type->id}}">{{$type->quotation_type}}</option>
                  @empty
                    <option value="0" disabled>No type</option>
                  @endforelse
                </select>
              </div>
              <div class="form-group d-none" id="company_name_form_group">
                <label for="exampleInputName1">Client Name</label>
                <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Client name" value="{{old('company_name')}}">
              </div>
              <div class="form-group d-none" id="customer_form_group">
                <label for="exampleInputName1">Client Name</label>
                <select name="selected_client" id="selected_client" class="form-control">
                  <option value="">~~Select Client~~</option>
                  @forelse ($customers as $customer)
                      <option value="{{$customer->id}}">{{$customer->customer_name}}</option>
                  @empty
                  <option value="" disabled>No customer</option>
                  @endforelse
                </select>
              </div>
               <div class="form-group d-none" id="tin_number_form_group">
                <label for="exampleInputName1">TIN</label>
                <input type="number" class="form-control" id="tin_number" name="tin_number" placeholder="TIN" value="{{old('tin_number')}}">
              </div>
               <div class="form-group d-none" id="address_form_group">
                <label for="exampleInputName1">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Client's address" value="{{old('address')}}">
              </div>
              <div class="form-group d-none" id="project_title_form_group">
                <label for="project_name">Project Name</label>
                <input type="text" class="form-control" id="project_title" name="project_title" placeholder="Project title" value="{{old('project_title')}}">
              </div>
              <div class="form-group d-none" id="customer_purchase_order_form_group">
                <label for="">P.O Number</label>
               <select name="customer_purchase_order_id" class="item_selector" style="width:100%" id="edit_customer_purchase_order_id">
                
               </select>
              </div> 
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-outline-danger rounded-0" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary rounded-0">Update</button>
        </div>
      </div>
    </form>
    </div>
  </div>