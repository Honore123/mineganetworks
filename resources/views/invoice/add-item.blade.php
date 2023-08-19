@extends('layouts.app')
@push('styles')
    <style>
        .table td{
            white-space: normal;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12 d-flex flex-wrap justify-content-between">
            <h3>{{$invoice->company_name}}'s Invoice</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{route('invoice.index')}}">Manage invoices</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Add items</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-12">
            @include('layouts.partials.notification')
        </div>
        <div class="col-12 grid-margin stretch-card mt-4">
            <div class="card">
              <div class="card-body">
                  <div class="form-group w-25">
                    <h5 for="exampleInputName1">Client:</h5>
                    <p class="mt-3">{{$invoice->company_name}}</p>
                    <p><span>TIN </span>{{$invoice->tin_number}}</p>
                    @if(!is_null($invoice->address))
                    <p>{{$invoice->address}}</p>
                    @endif
                  </div>
                  <div class="form-group w-25 border-1">
                    <h5 for="project_name">Project:</h5>
                    <p class="mt-3">{{$invoice->project_title}}</p>
                  </div>
                
                  <div class="d-flex flex-wrap justify-content-between">
                        <div>
                            <h6 class="mb-3">Purchase Order Information (No. {{$customer_po->po_number}})</h6>
                            <table class="table table-bordered">
                                <thead>
                                <tr><th>P.O total amount</th><th>Paid amount</th> <th>Remaining amount</th></tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{number_format( (float)$customer_po->total_amount,2,'.',',')}} Rwf</td>
                                        <td>{{number_format( ((float)$customer_po->total_amount - (float)$customer_po->remaining_amount),2,'.',',')}} Rwf</td>
                                        <td>{{number_format( (float)$customer_po->remaining_amount,2,'.',',')}} Rwf</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                       <div>
                        @if($invoice->status != 0 && $invoice->status != 2)
                        <button type="button" class="btn btn-primary rounded-0" data-toggle="modal" data-target="#add_item">Add Item</button>
                        @endif
                       </div>
                  </div>
                  @if($invoice->status != 0 && $invoice->status != 2)
                  @include('invoice.partials.add_item')
                  @include('invoice.partials.edit_item')
                  @endif
                  <div class="mt-4 table-responsive">
                    <h6 class="mb-3">Invoice Information ({{$invoice->invoice_code}})</h6>
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name/description</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                @if($invoice->status != 0 && $invoice->status != 2)
                                <th>Option</th>
                                @endif
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
                                @if($invoice->status != 0 && $invoice->status != 2)
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
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center" colspan="{{$invoice->status != 0 || $invoice->status != 2 ? '6' :'5'}}">No items yet!</td>
                            </tr>
                            
                            @endforelse
                            <tr>
                                <td colspan="{{$invoice->status != 0 && $invoice->status != 2 ? '5' :'4'}}" class="text-center"><b>Total</b></td>
                                <td><b>{{$total}} Rwf</b></td>
                            </tr>
                            <tr>
                                <td colspan="{{$invoice->status != 0 && $invoice->status != 2 ? '5' :'4'}}" class="text-center"><b>VAT(18%)</b> </td>
                                <td><b>{{$vat}} Rwf</b></td>
                            </tr> 
                            <tr>
                                <td colspan="{{$invoice->status != 0 && $invoice->status != 2 ? '5' :'4'}}" class="text-center"><b>Total Incl. VAT</b></td>
                                <td><b>{{$totalVat}} Rwf</b></td>
                            </tr> 
                        </tbody>
                    </table>
                  </div>
                  <div class="mt-5 mb-3 d-flex {{$invoice->status != 0 && $invoice->status != 2 ? 'justify-content-between':'justify-content-end'}}">
                    @if($invoice->status != 0 && $invoice->status != 2)
                    <button onclick="deleteInvoice({{$invoice->id}},'{{$invoice->company_name}}')" class="btn btn-outline-danger rounded-0">Delete</button>
                    @endif
                    @if($invoice->status != 0)
                    <a href="{{route('invoice.download', $invoice->id)}}" class="btn btn-primary rounded-0 mr-2">Download</a>
                    @endif
                  </div>
                  @if($invoice->status != 0 && $invoice->status != 2)
                  <form action="{{route('invoice.delete',$invoice->id)}}" method="POST" id="delete-invoice-{{$invoice->id}}">
                    @csrf
                    @method('DELETE')
                   </form>
                   @endif
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