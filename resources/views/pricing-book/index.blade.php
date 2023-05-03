@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>{{$customer->customer_name}}</h3>
            <h6 class="font-weight-normal mb-0">Product pricing book</h6>
        </div>
        <div class="col-md-12 d-flex justify-content-end">
            <a class="btn btn-primary rounded-0 mr-4" data-toggle="modal" data-target="#add_item">Add item</a>
            <button class="btn btn-outline-primary rounded-0 " data-toggle="modal" data-target="#upload_pricing_book">Upload Items</button>
            @include('pricing-book.partials.upload')
        </div>
        @include('pricing-book.partials.add_item')
        <div class="col-md-12 mt-3">
            @include('layouts.partials.notification')
        </div>
        <div class="col-md-12 mt-4 bg-white p-3">
            <table class="table table-bordered table-striped table-hover" id="pricing-book-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Sub-category</th>
                        <th>Measurement Unit</th>
                        <th>Unit Price</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
        $(document).ready(function(){
            $('#product_id').select2(); 
        })

       $('#product_id').on('select2:select', function (e) {
           const products = @json($products);
           const product_id = this.value;
           let result = products.find(product => product.id == product_id);
           $('#unit_price').val(result.product_unit_price);
        });

        function deleteAlert(id, name){
            swal.fire( {
                title:'Confirmation',
                text:'Do you want to remove ' + name,
                icon: 'warning',
                confirmButtonText: 'Yes',
                cancelButtonText:'No',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-item-'+ id).submit();
                }
            });
        }
    
        $('#pricing-book-table').DataTable({
            'paging': true,
            'scrollX': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'responsive': false,
            "aLengthMenu": [[10,25, 50, 75, -1], [10,25, 50, 75, "All"]],
            "iDisplayLength": 10,
            "processing":true,
            "serverSide":true,
            "ajax": {
                "url": "{{route('pricing-book.index',$customer->id)}}",
                "type": 'GET',
            },
            "columns": [
                {"data": 'DT_RowIndex', "name": 'DT_RowIndex', orderable: false,searchable: false,"className":"text-middle"},
                { "data": 'product.product_code', "name": 'product.product_code'},
                { "data": 'product.product_name', "name": 'product.product_name',"className":"text-middle"},
                { "data": 'product.category.category_name', "name": 'product.category.category_name',"className":"text-middle"},
                { "data": 'product.subcategory.sub_name', "name": 'product.subcategory.sub_name',"className":"text-middle"},
                {"data":"product.unit.unit_name", "name":"unit.unit_name","className":"text-middle"},
                {"data":"unit_price", "name":"unit_price","className":"text-middle"},
                {"data": 'option', "name": 'option', orderable:false, searchable:false,"className":"text-middle"},
            ]
        })
</script>
@endpush