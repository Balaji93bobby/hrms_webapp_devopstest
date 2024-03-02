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
                    <a routerlink="directory" href="{{url('vmt-employess/directory')}}">Dashboard</a>
                </li>
                <li routerlinkactive="active" class="active">
                    <a routerlink="tree" href="{{url('vmt-employee-hierarchy')}}">Directory</a>
                </li>
                <li routerlinkactive="active">
                    <a routerlink="logins" href="#/org/employees/logins">ORG
                                        structure</a>
                </li>
                <li routerlinkactive="active">
                    <a routerlink="profile-changes" href="#/org/employees/profile-changes">Onboarding</a>
                    <!---->
                </li>
                <li routerlinkactive="active">
                    <a routerlink="privateprofiles" href="#/org/employees/privateprofiles">Exit
                        </a>
                </li>
                <li routerlinkactive="active">
                    <a routerlink="privateprofiles" href="#/org/employees/privateprofiles">Documents
                        </a>
                </li>

                <li routerlinkactive="active">
                    <a routerlink="privateprofiles" href="#/org/employees/privateprofiles">Assets
                        </a>
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

@endsection
