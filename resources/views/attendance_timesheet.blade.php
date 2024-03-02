@extends('layouts.master')


<?php
//Icons for calendar
$svg_icon_rejected = '/images/icons/svg_icon_rejected.svg';
$svg_icon_approved = '/images/icons/svg_icon_accepted.svg';
$svg_icon_pending = '/images/icons/svg_icon_pending.svg';
$svg_icon_notApplied = '/images/icons/svg_icon_notApplied.svg';

?>
@section('title')
    @lang('translation.dashboards')
@endsection
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/calendar-vanila.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/attendance_calendar.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
@endsection
