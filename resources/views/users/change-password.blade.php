@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>Change password</h3>
        </div>
        <div class="col-md-12 mt-3">
            @include('layouts.partials.notification')
        </div>
        <div class="col-md-6 mt-4 pt-5 bg-white p-3">
           <form action="{{route('update.password',auth()->user()->id)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="">Current password</label>
                <input type="password" class="form-control" name="current_password" id="current_password">
            </div>
            <div class="form-group">
                <label for="">New password</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <div class="form-group">
                <label for="">Confirm password</label>
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
            </div>
            <div class="d-flex justify-content-end mt-5 mb-3">
                <button class="btn btn-primary rounded-0">Update</button>
            </div>
           </form>
        </div>
    </div>
@endsection