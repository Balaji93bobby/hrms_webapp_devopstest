
@extends('layouts.master')
@section('title')
    @lang('translation.dashboards')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/css/attendance.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/pages_profile.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <h2>Testings</h2>
<?php


    if (Schema::hasColumn('vmt_employee_payslip_v2', 'lwf')) {

        echo "Column exists";
        //$table->renameColumn('lwf','employee_lwf');
    }
    else {
        echo "Column doesnt exists";
    }



?>

@endsection
@section('script')

@endsection
