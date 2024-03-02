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
    <div class="mb-0 card pms_approval_wrapper ">
        <div class="card-body">
            <h6 class="my-2 text-lg font-semibold">PMS/OKR Approvals</h6>
            <div class="table-responsive">
            <div id="vjs_pmsApproval_Table"></div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@vite('resources/js/hrms/modules/approvals/pms/PMSApprovalTable.js')

@endsection
