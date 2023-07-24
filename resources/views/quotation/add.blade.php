@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 d-flex flex-wrap justify-content-between">
            <h3>New Quotation</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('quotation.index')}}">Manage quotations</a></li>
                <li class="breadcrumb-item active" aria-current="page">New</li>
              </ol>
          </nav>
        </div>
        <div class="col-6 grid-margin stretch-card mt-4">
            <div class="card">
              <div class="card-body">
                @include('layouts.partials.notification')
                <h4 class="card-title">Quotation form</h4>
                <p class="card-description">
                  Fill out the form below
                </p>
                <form class="forms-sample mt-3" action="{{route('quotation.store')}}" method="POST" id="new_quotation_form">
                  @csrf
                  <div class="form-group">
                    <label for="exampleInputName1">Client type</label>
                    <select name="customer_type" id="customer_type" onchange="customerType(this)" class="form-control">
                      <option value="0">~~Select Client type~~</option>
                      @forelse ($types as $type)
                      <option value="{{$type->id}}">{{$type->quotation_type}}</option>
                      @empty
                          <option value="0" disabled>No type</option>
                      @endforelse
                    </select>
                  </div>
                  <div class="form-group d-none" id="client_form_group">
                    <label for="exampleInputName1">Client Name</label>
                    <input type="text" class="form-control" id="client_name" name="client_name" placeholder="Client name">
                  </div>
                  <div class="form-group d-none" id="customer_form_group">
                    <label for="exampleInputName1">Client Name</label>
                    <select name="selected_client" id="selected_client" class="form-control">
                      <option value="">~~Select Client~~</option>
                      @forelse ($customers as $customer)
                          <option value="{{$customer->id}}">{{$customer->customer_name}}</option>
                      @empty
                      <option value="" disabled>No customer</option>
                      @endforelse
                    </select>
                  </div>
                  <div class="form-group d-none" id="title_form_group">
                    <label for="project_name">Project Name</label>
                    <input type="text" class="form-control" id="project_title" name="project_title" placeholder="Project title">
                  </div>
                  <div class="mt-5 mb-3 d-flex justify-content-end">
                    <button type="submit" onclick="btnDisable()" class="btn btn-primary rounded-0 mr-2 d-none" id="submit_btn">Save & Continue</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
          $('#new_quotation_form').on('submit', function() {
            $('#submit_btn').prop('disabled', true);
          });
      });
      function customerType(sel){
        const customer_type = sel.value;
        if(customer_type == 1) {
          $('#customer_form_group').removeClass('d-none');
          $('#client_form_group').addClass('d-none');
          $('#title_form_group').removeClass('d-none');
          $('#submit_btn').removeClass('d-none');
        } else if(customer_type == 2) {
          $('#client_form_group').removeClass('d-none');
          $('#customer_form_group').addClass('d-none');
          $('#title_form_group').removeClass('d-none');
          $('#submit_btn').removeClass('d-none');
        } else {
          $('#customer_form_group').addClass('d-none');
          $('#client_form_group').addClass('d-none');
          $('#title_form_group').addClass('d-none');
          $('#submit_btn').addClass('d-none');
        }
      }
    </script>
@endpush