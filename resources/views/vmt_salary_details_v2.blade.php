<?php use Carbon\Carbon; ?>
@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('public\assets\css\payCheck.css') }}" rel="stylesheet">
@endsection
@section('content')

@vite('resources/js/hrms/modules/paycheck/salary_details/salary_details.js')
<div id="salary_details"></div>

@endsection
@section('script')
@endsection
