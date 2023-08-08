<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="{{asset('assets/feather/feather.css')}}">
        <link rel="stylesheet" href="{{asset('assets/ti-icons/css/themify-icons.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/vendor.bundle.base.css')}}">
        <link rel="stylesheet" href="{{asset('custom/css/vertical-layout-light/style.css')}}">
        <link rel="shortcut icon" href="{{asset('images/logo1.min.png')}}" />

    </head>
    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
            @yield('content')
            </div>
        </div>
        
        <script src="{{asset('assets/js/vendor.bundle.base.js')}}"></script>
        <script src="{{asset('custom/js/off-canvas.js')}}"></script>
        <script src="{{asset('custom/js/hoverable-collapse.js')}}"></script>
        <script src="{{asset('custom/js/template.js')}}"></script>
        <script src="{{asset('custom/js/settings.js')}}"></script>
        <script src="{{asset('custom/js/todolist.js')}}"></script>
    </body>
</html>
