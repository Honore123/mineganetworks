@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>New Invoice</h3>
        </div>
        <div class="col-md-12">
            @include('layouts.partials.notification')
        </div>
        <div class="col-12 grid-margin stretch-card mt-4">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Invoice form</h4>
                <p class="card-description">
                  Fill out the form below
                </p>
                  <div class="form-group w-25">
                    <label for="exampleInputName1">Client Name:</label>
                    <h5 class="mt-3">{{$invoice->company_name}}</h5>
                  </div>
                  <div class="form-group w-25">
                    <label for="project_name">Project Name:</label>
                    <h5 class="mt-3">{{$invoice->project_title}}</h5>
                  </div>
                  <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary rounded-0" data-toggle="modal" data-target="#add_item">Add Item</button>
                  </div>
                  @include('invoice.partials.add_item')
                  @include('invoice.partials.edit_item')
                  <div class="mt-4 table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name/description</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                            <tr>
                                <td>{{$loop->iteration++}}</td>
                                <td>{{$item->item_name}}</td>
                                <td>{{number_format($item->unit_price,0,'.',',')}} Rwf</td>
                                <td>{{$item->quantity}}</td>
                                <td>{{number_format($item->total_price,0,'.',',')}} Rwf</td>
                                <td>
                                    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown">Option</button>
                                    <div class="dropdown-menu">
                                    <a class="dropdown-item" onclick="editItem({{$item->id}})">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <form action="{{route('invoiceItem.delete',$item->id)}}" method="POST" id="delete-invoice-item-{{$item->id}}">
                                      @csrf
                                      @method('DELETE')
                                    </form>
                                    <button onclick="deleteAlert({{$item->id}},'{{$item->item_name}}')" class="dropdown-item">Delete</button>
                                    </div> 
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center" colspan="6">No items yet!</td>
                            </tr>
                            
                            @endforelse
                            <tr>
                                <td colspan="5" class="text-center"><b>Total</b></td>
                                <td><b>{{$total}} Rwf</b></td>
                            </tr>
                            {{-- <tr>
                                <td colspan="6" class="text-center"><b>VAT</b> </td>
                                <td><b>{{$vat}} Rwf</b></td>
                            </tr> --}}
                            {{-- <tr>
                                <td colspan="6" class="text-center"><b>Total Incl. VAT</b></td>
                                <td><b>{{$totalVat}} Rwf</b></td>
                            </tr> --}}
                        </tbody>
                    </table>
                  </div>
                  <div class="mt-5 mb-3 d-flex justify-content-between">
                    <button onclick="deleteInvoice({{$invoice->id}},'{{$invoice->company_name}}')" class="btn btn-outline-danger rounded-0">Delete</button>
                    <a href="" class="btn btn-primary rounded-0 mr-2">Download</a>
                  </div>
                  <form action="{{route('invoice.delete',$invoice->id)}}" method="POST" id="delete-invoice-{{$invoice->id}}">
                    @csrf
                    @method('DELETE')
                   </form>
              </div>
            </div>
          </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function(){
            $('#product_id').select2();
            $('#edit_product_id').select2();
            
        })
        function deleteAlert(id, name){
            swal.fire( {
                title:'Confirmation',
                text:'Do you want to remove ' + name + ' from this invoice',
                icon: 'warning',
                confirmButtonText: 'Yes',
                cancelButtonText:'No',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-invoice-item-'+ id).submit();
                }
            });
        }

        function deleteInvoice(id, name){
            swal.fire( {
                title:'Confirmation',
                text:'Do you want to delete ' + name+"'s invoice? All item in this invoice will also be delete.",
                icon: 'warning',
                confirmButtonText: 'Yes',
                cancelButtonText:'No',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-invoice-'+ id).submit();
                }
            });
        }
        function editItem(id) {
            const items = @json($items);
            let item = items.find(item=> item.id == id);
            $("#edit_item_name").val(item.item_name);
            $("#edit_quantity").val(item.quantity);
            $("#edit_unit_price").val(item.unit_price);
            $("#edit_total_price").val(item.total_price);
            var url = '{{ route("invoiceItem.update", ":id") }}';
            url = url.replace(':id',id);
            $('#edit_item_form').attr("action",url);
        $('#edit_item').modal('show');
        }
        function totalPrice() {
            let quantity = $('#quantity').val();
            let unit = $('#unit_price').val();
            const totalPrice = quantity * unit;
            $('#total_price').val(totalPrice);
        }
        function editTotalPrice() {
            let quantity = $('#edit_quantity').val();
            let unit = $('#edit_unit_price').val();
            const totalPrice = quantity * unit;
            $('#edit_total_price').val(totalPrice);
        }
    </script>
@endpush