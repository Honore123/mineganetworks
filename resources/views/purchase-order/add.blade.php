@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>New Purchase order</h3>
        </div>
        <div class="col-6 grid-margin stretch-card mt-4">
            <div class="card">
              <div class="card-body">
                @include('layouts.partials.notification')
                <h4 class="card-title">Purchase order form</h4>
                <p class="card-description">
                  Fill out the form below
                </p>
                <form class="forms-sample mt-3" action="{{route('purchase-order.store')}}" method="POST">
                  @csrf
                  <div class="form-group" id="customer_form_group">
                    <label for="exampleInputName1">Vendor Name</label>
                    <select name="vendor_id" id="vendor_id" class="form-control">
                      <option value="">~~Select Vendor~~</option>
                      @forelse ($vendors as $vendor)
                          <option value="{{$vendor->id}}">{{$vendor->vendor_name}}</option>
                      @empty
                      <option value="" disabled>No vendor</option>
                      @endforelse
                    </select>
                  </div>
                  <div class="mt-5 mb-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary rounded-0 mr-2" id="submit_btn">Save & Continue</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
    </div>
@endsection