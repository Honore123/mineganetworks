<div class="modal fade" id="expense_edit_{{$expense->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="forms-sample" action="{{route('expense.update',$expense->id)}}" method="post">
          @csrf
          @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit expense</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="">Name</label>
              <input type="text" class="form-control" name="expense_name" placeholder="Ex: Fuel" value="{{$expense->expense_name}}">
            </div>  
          <div class="form-group">
            <label for="">Amount</label>
            <input type="number" class="form-control" name="expense_amount" value="{{$expense->expense_amount}}">
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