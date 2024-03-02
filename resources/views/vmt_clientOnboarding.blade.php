@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/onboarding.css') }}">
@endsection

@section('content')
    @vite('resources/js/hrms/modules/configurations/client_onboarding/client_onboarding_master.js')
    <div id="clientOnboarding"></div>
@endsection
