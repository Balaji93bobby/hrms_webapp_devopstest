@extends('layouts.master')
@section('title')
    @lang('translation.dashboards')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/css/hr_dashboard.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/holiday.css') }}">
    <!-- <link rel="stylesheet" href="{{ URL::asset('/assets/css/calendar-vanila.css') }}"> -->
    <!-- <script src="{{ URL::asset('assets/js/calendar-vanila.js') }}" defer></script> -->

    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('loading')
    <section id="loading">
        <div class='face'>
            <div class='loader-container'>
                <img id="loader-image" src="{{ URL::asset('assets/images/abs logo.png') }}" />
                <span class='loading'></span>
            </div>
        </div>
    </section>
@endsection

@section('content')
@endsection
