<div class="modal fade" id="upload_document" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="forms-sample" action="{{route('document.store')}}" method="post" enctype="multipart/form-data">
          @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Upload document</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
              <label for="">Name</label>
              <input type="text" class="form-control" name="name" id="name" placeholder="Ex: Airtel PO, Tower design doc..." value={{old('name')}}>
          </div>
          <div class="form-group">
            <label for="file">File</label>
            <input type="file" class="form-control" id="document" name="document" placeholder="File">
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