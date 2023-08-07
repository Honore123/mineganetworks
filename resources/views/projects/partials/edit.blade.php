<div class="modal fade" id="project_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="forms-sample"  method="post" id="edit_project_form">
          @csrf
          @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Project</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
              <label for="">Project name</label>
              <input type="text" class="form-control" name="project_name" id="edit_project_name" placeholder="Project name">
          </div> 
          <div class="form-group">
            <label for="">Client/Company</label>
            <input type="text" class="form-control" name="company_name" id="edit_company_name" placeholder="Client/Company name">
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