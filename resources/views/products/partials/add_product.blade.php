<div class="modal fade" id="new_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="forms-sample" action="{{route('product.store')}}" method="post">
          @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="product_category">Product Category</label>
            <select name="category_id" id="category_id" class="form-control">
              <option value="">Select Category</option>
              @forelse ($categories as $category)
                  <option value="{{$category->id}}">{{$category->category_name}}</option>
              @empty
                  <option value="" disabled>No category</option>
              @endforelse
            </select>
          </div>
          <div class="form-group">
            <label for="product_category">Product Sub-category</label>
            <select name="subcategory_id" id="subcategory_id" class="form-control">
              <option value="">Select sub-category</option>
              @forelse ($subcategories as $subcategory)
                  <option value="{{$subcategory->id}}">{{$subcategory->sub_name}}</option>
              @empty
                  <option value="" disabled>No sub-category</option>
              @endforelse
            </select>
          </div>
          <div class="form-group">
              <label for="">Product Name</label>
              <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Product/Service name">
          </div>
          <div class="form-group">
            <label for="price">Quantity</label>
            <input type="number" class="form-control" id="product_quantity" name="product_quantity" placeholder="Quantity">
          </div>
          <div class="form-group">
            <label for="product_category">Measurement Unit</label>
            <select name="measurement_unit" id="measurement_unit" class="form-control">
              <option value="">Select Unit</option>
              @forelse ($units as $unit)
                  <option value="{{$unit->id}}">{{$unit->unit_name}} ({{$unit->unit_abbr}})</option>
              @empty
                  <option value="" disabled>No unit</option>
              @endforelse
            </select>
          </div>
          <div class="form-group">
            <label for="price">Unit Price</label>
            <input type="number" class="form-control" id="product_unit_price" name="product_unit_price" placeholder="Unit Price">
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-outline-danger rounded-0" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary rounded-0">Save</button>
        </div>
      </div>
    </form>
    </div>
  </div>