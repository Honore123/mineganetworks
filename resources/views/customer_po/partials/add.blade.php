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
          <div class="form-group" id="project_form_group">
            <label for="exampleInputName1">Project name</label>
            <select name="project_id" id="selected_project" style="width: 100%" class="item-selector">
              <option value="">~~Select project~~</option>
              @forelse ($projects as $project)
                  <option value="{{$project->id}}">{{$project->project_name}} ({{$project->company_name}})</option>
              @empty
              <option value="" disabled>No project</option>
              @endforelse
            </select>
          </div>
          <div class="form-group">
            <label for="">Total amount</label>
            <input type="number" class="form-control" name="total_amount" id="total_amount" step=".01" placeholder="Total amount">
          </div>
          <div class="form-group">
            <label for="datetimepicker">PO Date</label>
            <input type="text" class="form-control" id="datetimepicker" id="po_date" name="po_date" />
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