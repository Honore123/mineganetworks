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
        <!-- endinject -->
        <!-- Plugin css for this page -->
        <link rel="stylesheet" href="{{asset('assets/datatables.net-bs4/dataTables.bootstrap4.css')}}">
        <link rel="stylesheet" href="{{asset('assets/ti-icons/css/themify-icons.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('custom/js/select.dataTables.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/select2/select2.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/select2-bootstrap-theme/select2-bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/datatable_buttons/buttons.dataTables.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/datetimepicker/datetime_picker.css')}}">
        <!-- End plugin css for this page -->
        <!-- inject:css -->
        <link rel="stylesheet" href="{{asset('custom/css/vertical-layout-light/style.css')}}">
        <!-- endinject -->
        <link rel="shortcut icon" href="{{asset('images/logo1.min.png')}}" />
       @stack('styles')
    </head>
    <body class="sidebar-fixed">
        <div class="container-scroller">
           @include('layouts.partials.navbar')
           
            <div class="container-fluid page-body-wrapper">
             @include('layouts.partials.sidebar')
              
              
              <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                 </div>
               
                @include('layouts.partials.footer')
              </div>
              
            </div>   
            
          </div>
        <script src="{{asset('assets/js/vendor.bundle.base.js')}}"></script>
        <!-- endinject -->
        <!-- Plugin js for this page -->
        <script src="{{asset('assets/chart.js/Chart.min.js')}}"></script>
        <script src="{{asset('assets/datatables.net/jquery.dataTables.js')}}"></script>
        <script src="{{asset('assets/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
        <script src="{{asset('assets/datatable_buttons/dataTables.buttons.min.js')}}"></script>
        <script src="{{asset('assets/datatable_buttons/buttons.bootstrap4.min.js')}}"></script>
        <script src="{{asset('assets/datatable_buttons/buttons.colVis.min.js')}}"></script>
        <script src="{{asset('assets/jszip/jszip.min.js')}}"></script>
        <script src="{{asset('assets/pdfmake/pdfmake.min.js')}}"></script>
        <script src="{{asset('assets/pdfmake/vfs_fonts.js')}}"></script>
        <script src="{{asset('assets/datatable_buttons/buttons.html5.min.js')}}"></script>
        <script src="{{asset('assets/datatable_buttons/buttons_1.colVis.min.js')}}"></script>
        <script src="{{asset('assets/select2/select2.min.js')}}"></script>
        <script src="{{asset('assets/momentum/momentum.js')}}"></script>
        <script src="{{asset('custom/js/dataTables.select.min.js')}}"></script>
        <script src="{{asset('assets/datetimepicker/datetime_picker.min.js')}}"></script>
       
      
        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <script src="{{asset('custom/js/off-canvas.js')}}"></script>
        <script src="{{asset('custom/js/hoverable-collapse.js')}}"></script>
        <script src="{{asset('custom/js/template.js')}}"></script>
        <script src="{{asset('custom/js/settings.js')}}"></script>
        <script src="{{asset('custom/js/todolist.js')}}"></script>
        <!-- endinject -->
        <!-- Custom js for this page-->
        <script src="{{asset('custom/js/dashboard.js')}}"></script>
        <script src="{{asset('custom/js/Chart.roundedBarCharts.js')}}"></script>
        <script src="{{asset('custom/js/select2.js')}}"></script>
        <script src="{{asset('assets/sweetalert/sweetalert.js')}}"></script>
        <!-- End custom js for this page-->
        @stack('scripts')
    </body>
</html>
