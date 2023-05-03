@extends('layouts.guest')
@section('content')
<div class="content-wrapper d-flex align-items-center auth px-0">
    <div class="row w-100 mx-0">
        <div class="col-lg-4 mx-auto">
        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
            <div class="brand-logo">
            <img src="{{asset('images/logo1.png')}}" alt="logo">
            </div>
            <h4>Hello! let's get started</h4>
            <h6 class="font-weight-light">Sign in to continue.</h6>
           @include('layouts.partials.notification')
            <form class="pt-3" method="POST" action="{{route('login')}}">
            @csrf
            <div class="form-group">
                <input type="email" name="email" value="{{old("email")}}" class="form-control form-control-lg" id="email" placeholder="Email" required autofocus>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control form-control-lg" id="password" placeholder="Password" required autocomplete="current-password">
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
            </div>
            <div class="my-2 d-flex justify-content-between align-items-center">
                <div class="form-check">
                <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                    Keep me signed in
                </label>
                </div>
                <a href="{{route('password.request')}}" class="auth-link text-black">Forgot password?</a>
            </div>
            
            </form>
        </div>
        </div>
    </div>
</div>
@endsection

   