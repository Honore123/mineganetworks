<div class="modal fade" id="edit_document_rigger" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="forms-sample" method="post" id="edit_rigger_doc_form" enctype="multipart/form-data">
          @csrf
          @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Rigger document</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
              <label for="">Document type</label>
              <input type="text" class="form-control" name="document_type" id="edit_document_type" placeholder="Ex: Certificate, National ID...">
          </div>
          <div class="form-group">
            <label for="">Issued date</label>
            <input type="date" class="form-control" name="issued_date" id="edit_issued_date">
        </div>
          <div class="form-group">
            <label for="">Expiry date</label>
            <input type="date" class="form-control" name="expiry_date" id="edit_expiry_date">
        </div>
          <div class="form-group">
            <label for="file">File</label>
            <input type="file" class="form-control" id="edit_document" name="document" placeholder="File">
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