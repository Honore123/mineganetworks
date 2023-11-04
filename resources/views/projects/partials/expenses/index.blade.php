<div class="col-md-12 mt-2 d-flex justify-content-between">
    <h5>Expenses</h5>
    <button class="btn btn-primary rounded-0" data-toggle="modal" data-target="#expense_add">Add expense</button>
    @include('projects.partials.expenses.partials.add')
</div>
<div class="col-md-12 mt-3">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name/description</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $expense)
            <tr>
                <td>{{$loop->iteration ++}}</td>
                <td>{{$expense->expense_name}}</td>
                <td>{{number_format($expense->expense_amount,0,'.',',')}}</td>
                <td>{{$expense->created_at->format('d-m-Y')}}</td>
                <td>
                    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown">Option</button>
                    <div class="dropdown-menu">
                        <button class="dropdown-item py-2" data-toggle="modal" data-target="#expense_edit_{{$expense->id}}">Edit</button>
                        <div class="dropdown-divider"></div>
                        <form action="{{route('expense.delete',$expense->id)}}" method="POST" id="delete_expense_form_{{$expense->id}}">
                            @csrf
                            @method('DELETE')
                        </form>
                        <button class="dropdown-item" onclick="deleteExpense({{$expense->id}},'{{$expense->expense_name}}')" >Delete</button>
                    </div> 
                </td>
                @include('projects.partials.expenses.partials.edit')
            </tr>
            @empty
            <tr>
                <td class="text-center" colspan="5">No expense yet</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>