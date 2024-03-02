@extends('layouts.master')

@section('title')
@lang('translation.dashboards')
@endsection
@section('content')
{{-- @component('components.attendance_breadcrumb')
        @slot('li_1')
        @endslot
    @endcomponent --}}

@vite('resources/js/hrms/modules/Organization/manage_welcome_mails_status/ManageWelcomeMailStatus.js')
<div id="vjs_ManageWelcomeMailStatus"></div>

@endsection
