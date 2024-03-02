@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/employee-directory.css') }}">
<!--Font Awesome-->
<link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/fontawesome-all.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/fontawesome.css') }}">

@endsection
@section('content')

<div class="attendance-hierarchy-wrapper">
    <div class="row">
        <div class="col-12">
            <ul class="nav sub-topnav  topnav">
                <li routerlinkactive="active">
                    <a routerlink="directory" href="{{route('paycheckDashboard')}}">Dashboard</a>
                </li>
                <li routerlinkactive="active" class="active">
                    <a routerlink="tree" href="{{route('vmt_salary_details')}}">Salary
                                        Details</a>
                </li>

                <li routerlinkactive="active">
                    <a routerlink="directory" href="{{url('vmt_investments')}}">Investments</a>
                </li>

                <li routerlinkactive="active">
                    <a routerlink="tree" href="{{url('vmt_form16')}}">Form 16</a>
                </li>


            </ul>
        </div>
    </div>
</div>

@endsection
@section('script')
<!-- ui notifications -->

<script src="{{ URL::asset('/assets/libs/prismjs/prismjs.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/pages/notifications.init.js') }}"></script>
<!-- dashboard init -->
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>


@endsection
