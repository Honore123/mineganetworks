<div class="modal fade" id="project_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="forms-sample" action="{{route('project.store')}}" method="post">
          @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Project</h5>
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
          <div class="form-group d-none" id="client_form_group">
            <label for="">Client/Company</label>
            <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Client/Company name">
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
          <div class="form-group d-none" id="title_form_group">
              <label for="">Project name</label>
              <input type="text" class="form-control" name="project_name" id="project_name" placeholder="Project name">
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