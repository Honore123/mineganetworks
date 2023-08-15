<div class="modal fade" id="customer_po_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="forms-sample" action="{{route('customer-po.store')}}" method="post" enctype="multipart/form-data">
          @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Customer P.O</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
              <label for="">PO Number</label>
              <input type="text" class="form-control" name="po_number" id="po_number" placeholder="PO Number">
          </div>
          <div class="form-group">
            <label for="">Project title</label>
            <input type="text" class="form-control" name="project_title" id="project_title" placeholder="Project title">
          </div>
          <div class="form-group">
            <label for="">Company name</label>
            <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Company Name">
          </div>
          <div class="form-group">
            <label for="">Total amount</label>
            <input type="number" class="form-control" name="total_amount" id="total_amount" placeholder="Total amount">
          </div>
          <div>
            <label for="">P.O File</label>
            <input type="file" class="form-control" name="file" id="file" placeholder="PO File">
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