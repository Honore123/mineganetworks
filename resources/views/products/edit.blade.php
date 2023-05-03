@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6 card">
            <div class="card-body">
                <h3 class="card-title">Edit Product</h3>
                  <p class="card-description">
                    {{$product->product_name}}
                  </p>
                <form action="{{route('product.update',$product->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="product_category">Product Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                          <option value="">Select Category</option>
                          @forelse ($categories as $category)
                              <option value="{{$category->id}}" {{$category->id == $product->category->id ? 'selected': ''}}>{{$category->category_name}}</option>
                          @empty
                              <option value="" disabled>No category</option>
                          @endforelse
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="product_category">Product sub-category</label>
                        <select name="subcategory_id" id="subcategory_id" class="form-control">
                          <option value="">Select sub-category</option>
                          @forelse ($subcategories as $subcategory)
                              <option value="{{$subcategory->id}}" {{$subcategory->id == $product->subcategory->id ? 'selected': ''}}>{{$subcategory->sub_name}}</option>
                          @empty
                              <option value="" disabled>No category</option>
                          @endforelse
                        </select>
                      </div>
                      <div class="form-group">
                          <label for="">Product Name</label>
                          <input type="text" class="form-control" name="product_name" id="product_name" value="{{$product->product_name}}" placeholder="Product/Service name">
                      </div>
                      <div class="form-group">
                        <label for="price">Quantity</label>
                        <input type="number" class="form-control" id="product_quantity" name="product_quantity" value={{$product->product_quantity}} placeholder="Quantity">
                      </div>
                      <div class="form-group">
                        <label for="product_category">Measurement Unit</label>
                        <select name="measurement_unit" id="measurement_unit" class="form-control">
                          <option value="">Select Unit</option>
                          @forelse ($units as $unit)
                              <option value="{{$unit->id}}" {{$unit->id == $product->unit->id ? 'selected': ''}}>{{$unit->unit_name}} ({{$unit->unit_abbr}})</option>
                          @empty
                              <option value="" disabled>No unit</option>
                          @endforelse
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="price">Unit Price</label>
                        <input type="number" class="form-control" id="product_unit_price" name="product_unit_price" value="{{$product->product_unit_price}}" placeholder="Unit Price">
                      </div>
                      <div class="form-group d-flex justify-content-between">
                        <a href="{{route('product.index')}}" class="btn btn-outline-danger rounded-0" data-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-primary rounded-0">Update</button>
                      </div>
                </form>
            </div>
           
        </div>
    </div>
@endsection