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
        <div class="col-md-12">
            <h3>All Product</h3>
        </div>
        <div class="col-md-12 d-flex justify-content-end">
            <a class="btn btn-primary rounded-0 mr-4" data-toggle="modal" data-target="#new_product">New Product</a>
            <button class="btn btn-outline-primary rounded-0 " data-toggle="modal" data-target="#upload_product">Upload Products</button>
            @include('products.partials.upload')
        </div>
        @include('products.partials.add_product')
        <div class="col-md-12 mt-3">
            @include('layouts.partials.notification')
        </div>
        <div class="col-md-12 mt-4 bg-white p-3">
            <table class="table table-bordered table-striped table-hover table-responsive" id="products-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Sub-category</th>
                        <th>Unit</th>
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
<script>
    function deleteAlert(id, name){
            swal.fire( {
                title:'Confirmation',
                text:'Do you want to delete ' + name,
                icon: 'warning',
                confirmButtonText: 'Yes',
                cancelButtonText:'No',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-product-'+ id).submit();
                }
            });
        }
        $('#products-table').DataTable({
            'dom':'lBfrtip',
            'paging': true,
            'scrollX': false,
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
                "url": "{{route('product.index')}}",
                "type": 'GET',
            },
            "columns": [
                {"data": 'DT_RowIndex', "name": 'DT_RowIndex', orderable: false,searchable: false,"className":"text-middle", "width":"1%"},
                { "data": 'product_code', "name": 'product_code'},
                { "data": 'product_name', "name": 'product_name',"className":"warp", "width":"30%"},
                { "data": 'category.category_name', "name": 'category.category_name',"className":"text-middle"},
                { "data": 'subcategory.sub_name', "name": 'subcategory.sub_name',"className":"text-middle"},
                {"data":"unit.unit_name", "name":"unit.unit_name","className":"text-middle"},
                {"data":"product_unit_price", "name":"product_unit_price","className":"text-middle"},
                {"data": 'option', "name": 'option', orderable:false, searchable:false,"className":"text-middle"},
            ],
            "buttons": [
                {extend: 'colvis', className: 'btn btn-warning', columns: ':visible'},
                { extend: 'excelHtml5', className: 'btn btn-info', exportOptions: {columns:':visible'} },
                { extend: 'pdfHtml5', orientation: 'landscape', pageSize: 'A4', className: 'btn btn-success',exportOptions: {columns:':visible'} },
            ],
        })
</script>
@endpush