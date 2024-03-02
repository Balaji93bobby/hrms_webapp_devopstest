@extends('layouts.master-without-nav')
@section('title')
@endsection
@section('css')
<link href="{{ URL::asset('assets/css/login_page.css') }}" rel="stylesheet">
<style>
    .fade {
        transition: opacity 0.2s linear !important;
    }
</style>
@endsection
@section('content')
<!doctype html>
<html lang="en">

<head>
</head>

<body>

    @vite( 'resources/js/hrms/modules/login_Page/login_Page.js')
    <div id="login_Page"></div>

</body>

</html>








@endsection
