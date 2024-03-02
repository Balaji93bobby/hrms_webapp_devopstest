{{-- @yield('css') --}}
<!-- Bootstrap Css -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

{{-- BOOTSTRAP 4 COMMENTED --}}
<!-- {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}} -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

<link href="{{ URL::asset('assets/libs/swiper/swiper.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/quicksand.css') }}">

<!-- Icons Css -->
<link href="{{ URL::asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

<!-- App Css-->
<link href="{{ URL::asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/css/shared.css') }}" id="app-style" rel="stylesheet" type="text/css" />

<!--font-awesome-->

<link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/fontawesome-all.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/fontawesome.css') }}">


<!-- for grid js table design -->
<link rel="stylesheet" href="{{ URL::asset('assets/libs/gridjs/gridjs.min.css') }}">


<link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

<!--Animate for only chartist CSS-->
{{-- reference url : https://cdnjs.com/libraries/chartist --}}
<link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/chartist.min.css') }}">

<!--Map-->
{{-- reference url : https://www.npmjs.com/package/jsvectormap --}}
<link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/jquery-jvectormap-2.0.2.css') }}">

{{-- notification toast  --}}
{{-- reference url : https://codeseven.github.io/toastr/demo.html --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

<link href='//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@vite('resources/scss/main.scss')
@vite('resources/scss/views/main_dashboard.scss')
@yield('css')
