<!-- <?php use Carbon\Carbon; ?> -->

@extends('layouts.master')
<!-- @section('title')
    @lang('translation.settings')
@endsection -->
@section('css')
    <!-- <link rel="stylesheet" href="{{ URL::asset('/assets/css/pages_profile.css') }}"> -->
@endsection
@section('content')
    @vite('resources/js/hrms/modules/profile_pages/ProfilePageNew.js')
    <div id="profilePage"></div>
@endsection

