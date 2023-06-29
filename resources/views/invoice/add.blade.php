@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>New Invoice</h3>
        </div>
        <div class="col-6 grid-margin stretch-card mt-4">
            <div class="card">
              <div class="card-body">
                @include('layouts.partials.notification')
                <h4 class="card-title">Client's information</h4>
                <p class="card-description">
                  Fill out the form below
                </p>
                <form class="forms-sample mt-3" action="{{route('invoice.store')}}" method="POST" id="new_invoice_form">
                  @csrf
                  <div class="form-group" id="client_form_group">
                    <label for="exampleInputName1">Client Name</label>
                    <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Client name" value="{{old('company_name')}}">
                  </div>
                   <div class="form-group" id="client_form_group">
                    <label for="exampleInputName1">TIN</label>
                    <input type="number" class="form-control" id="tin_number" name="tin_number" placeholder="TIN" value="{{old('tin_number')}}">
                  </div>
                   <div class="form-group" id="client_form_group">
                    <label for="exampleInputName1">Address</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Client's address" value="{{old('address')}}">
                  </div>
                  <div class="form-group " id="title_form_group">
                    <label for="project_name">Project Name</label>
                    <input type="text" class="form-control" id="project_title" name="project_title" placeholder="Project title" value="{{old('project_title')}}">
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
@push('scripts')
    <script>
        $(document).ready(function() {
          $('#new_invoice_form').on('submit', function() {
            $('#submit_btn').prop('disabled', true);
          });
      });
    </script>
@endpush