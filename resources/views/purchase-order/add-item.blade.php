@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>New Purchase Order</h3>
        </div>
        <div class="col-md-12">
            @include('layouts.partials.notification')
        </div>
        <div class="col-12 grid-margin stretch-card mt-4">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Purchase order form</h4>
                <p class="card-description">
                  Fill out the form below
                </p>
                  <div class="form-group w-25">
                    <label for="exampleInputName1">Vendor Name:</label>
                    <h5 class="mt-3">{{$purchaseOrder->vendor->vendor_name}}</h5>
                  </div>
                  <div class="form-group w-25">
                    <label for="exampleInputName1">Purchase Order:</label>
                    <h5 class="mt-3">P{{$purchaseOrder->po_code}}</h5>
                  </div>
                  <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary rounded-0" data-toggle="modal" data-target="#add_item">Add Item</button>
                  </div>
                  @include('purchase-order.partials.add_item')
                
                  <div class="mt-4 table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item code</th>
                                <th>Name/description</th>
                                <th>UOM</th>
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
                                <td>{{$item->product->product_code}}</td>
                                <td>{{$item->product->product_name}}</td>
                                <td>{{$item->product->unit->unit_name}} ({{$item->product->unit->unit_abbr}})</td>
                                <td>{{number_format($item->unit_price,0,'.',',')}} Rwf</td>
                                <td>{{$item->quantity}}</td>
                                <td>{{number_format($item->total_price,0,'.',',')}} Rwf</td>
                                <td>
                                    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown">Option</button>
                                    <div class="dropdown-menu">
                                    <a class="dropdown-item" data-toggle="modal" data-target="#edit_item_{{$item->id}}">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <form action="{{route('purchase-order-product.delete',$item->id)}}" method="POST" id="delete-purchase-product-{{$item->id}}">
                                      @csrf
                                      @method('DELETE')
                                    </form>
                                    <button onclick="deleteAlert({{$item->id}},'{{$item->product->product_name}}')" class="dropdown-item">Delete</button>
                                    </div> 
                                </td>
                            </tr>
                            @include('purchase-order.partials.edit_item')
                            @empty
                            <tr>
                                <td class="text-center" colspan="8">No items yet!</td>
                            </tr>
                            
                            @endforelse
                            <tr>
                                <td colspan="6" class="text-center"><b>Total Excl. VAT</b></td>
                                <td><b>{{$total}} Rwf</b></td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-center"><b>VAT</b> </td>
                                <td><b>{{$vat}} Rwf</b></td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-center"><b>Total Incl. VAT</b></td>
                                <td><b>{{$totalVat}} Rwf</b></td>
                            </tr>
                        </tbody>
                    </table>
                  </div>
                  <div class="mt-5 mb-3 d-flex justify-content-between">
                    <button onclick="deletePurchaseOrder({{$purchaseOrder->id}},'{{$purchaseOrder->vendor->vendor_name}}')" class="btn btn-outline-danger rounded-0">Delete</button>
                    <a href="{{route('purchase-order.download',$purchaseOrder->id)}}" class="btn btn-primary rounded-0 mr-2">Download</a>
                  </div>
                  <form action="{{route('purchase-order.delete',$purchaseOrder->id)}}" method="POST" id="delete-purchase-order-{{$purchaseOrder->id}}">
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
                text:'Do you want to remove ' + name + ' from this purchase order',
                icon: 'warning',
                confirmButtonText: 'Yes',
                cancelButtonText:'No',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-purchase-product-'+ id).submit();
                }
            });
        }

        function deletePurchaseOrder(id, name){
            swal.fire( {
                title:'Confirmation',
                text:'Do you want to delete ' + name+"'s purchase order? All item in this pruchase order will also be delete.",
                icon: 'warning',
                confirmButtonText: 'Yes',
                cancelButtonText:'No',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-purchase-order-'+ id).submit();
                }
            });
        }

        function totalPrice(){
            const quantity = $('#quantity').val();
            const price = $('#unit_price').val();
            let totalPrice = quantity * price;
            if(totalPrice) {
                $('#total_price').val(totalPrice);
            }else {
                $('#total_price').val(0);
            }
        }
        function editTotalPrice(){
            const quantity = $('#edit_quantity').val();
            const price = $('#edit_unit_price').val();
            let totalPrice = quantity * price;
            if(totalPrice) {
                $('#edit_total_price').val(totalPrice);
            }else {
                $('#edit_total_price').val(0);
            }  
        }

    </script>
@endpush