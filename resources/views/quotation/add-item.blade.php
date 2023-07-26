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
            <h3>{{$quotation->client_name}}'s quotation</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{route('quotation.index')}}">Manage quotations</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Add items</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-12">
            @include('layouts.partials.notification')
        </div>
        <div class="col-12 grid-margin stretch-card mt-2">
            <div class="card">
              <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputName1">Client Name:</label>
                    <h5 class="mt-2">{{$quotation->client_name}}</h5>
                  </div>
                  <div class="form-group">
                    <label for="project_name">Project Name:</label>
                    <h5 class="mt-2">{{$quotation->project_title}}</h5>
                  </div>
                  <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary rounded-0" data-toggle="modal" data-target="#add_item">Add Item</button>
                  </div>
                  @include('quotation.partials.add_item')
                
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
                                    <a class="dropdown-item" data-toggle="modal" onclick="editProduct({{$item->id}})" data-target="#edit_item_{{$item->id}}">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <form action="{{route('quotation-product.delete',$item->id)}}" method="POST" id="delete-quotation-product-{{$item->id}}">
                                      @csrf
                                      @method('DELETE')
                                    </form>
                                    <button onclick="deleteAlert({{$item->id}},'{{$item->product->product_name}}')" class="dropdown-item">Delete</button>
                                    </div> 
                                </td>
                            </tr>
                            @include('quotation.partials.edit_item')
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
                    <button onclick="deleteQuotation({{$quotation->id}},'{{$quotation->client_name}}')" class="btn btn-outline-danger rounded-0">Delete</button>
                    <a href="{{route('quotation.download',$quotation->id)}}" class="btn btn-primary rounded-0 mr-2">Download</a>
                  </div>
                  <form action="{{route('quotation.delete',$quotation->id)}}" method="POST" id="delete-quotation-{{$quotation->id}}">
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
           
        })
        function editProduct($id) {
            $('#edit_product_'+$id).select2(); 
        }
        function deleteAlert(id, name){
            swal.fire( {
                title:'Confirmation',
                text:'Do you want to remove ' + name + ' from this quotation',
                icon: 'warning',
                confirmButtonText: 'Yes',
                cancelButtonText:'No',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-quotation-product-'+ id).submit();
                }
            });
        }

        function deleteQuotation(id, name){
            swal.fire( {
                title:'Confirmation',
                text:'Do you want to delete ' + name+"'s quotation? All item in this quotation will also be delete.",
                icon: 'warning',
                confirmButtonText: 'Yes',
                cancelButtonText:'No',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-quotation-'+ id).submit();
                }
            });
        }

        function setSource(sel){
            if(sel.value){
                $.get("/quotation/products/source/" + sel.value,(response)=>{
                    let output = '<option value="">Select Item</option>';
                    response = JSON.parse(response);
                    if(sel.value != 0){
                        $.each(response,(key,item)=>{
                            output += ' <option value="'+item.product.id+'">'+item.product.product_name+'</option>'
                        });
                    } else {
                        $.each(response,(key,item)=>{
                            output += ' <option value="'+item.id+'">'+item.product_name+'</option>'
                        });
                    }
                    $("#product_id").html(output);
                });
            }
        }
    </script>
@endpush