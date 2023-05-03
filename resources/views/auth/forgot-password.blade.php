@extends('layouts.guest')
@section('content')
<div class="content-wrapper d-flex align-items-center auth px-0">
    <div class="row w-100 mx-0">
        <div class="col-lg-4 mx-auto">
        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
            <div class="brand-logo">
            <img src="{{asset('images/logo1.png')}}" alt="logo">
            </div>
            <h4>Forgot your password?</h4>
            <h6 class="font-weight-light">No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</h6>
            @include('layouts.partials.notification')
            <form class="pt-3" method="POST" action="{{route('password.email')}}">
            @csrf
            <div class="form-group">
                <input type="email" name="email" value="{{old("email")}}" class="form-control form-control-lg" id="email" placeholder="Email" required autofocus>
            </div>
           
            <div class="mt-3">
                <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">EMAIL PASSWORD RESET LINK</button>
            </div>
            
            </form>
        </div>
        </div>
    </div>
</div>
@endsection
