<div class="modal fade" id="upload_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Upload Products</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form class="forms-sample" action="{{route('product.upload')}}" method="POST" enctype="multipart/form-data">
          @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="file_products">File</label>
            <input type="file" class="form-control" id="file" name="file" placeholder="File">
            <small>Allowed files: .xls, .xlsx, and .csv</small>
          </div>
          <div class="form-group">
            <label for="file_products">Download excel format</label>
            <a href="{{asset('excel_sample/upload_format.xlsx')}}"> here</a>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-outline-danger rounded-0" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary rounded-0">Upload</button>
        </div>
      </form>
      </div>
    </div>
</div>