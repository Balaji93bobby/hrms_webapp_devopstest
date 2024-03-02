@extends('layouts.master')

@section('title')
    @lang('translation.dashboards')
@endsection
@section('content')
    {{-- @component('components.attendance_breadcrumb')
        @slot('li_1')
        @endslot
    @endcomponent --}}



        <div class="mb-0 card approvals_wrapper">
            <div class="card-body ">
                <div class="filter-content">
                    <div class="row">
                        <div class="col-sm-12 col-xxl-6 col-md-6 col-xl-6 col-lg-6">
                            <h6 class="my-2 text-lg font-semibold">Investment Forms Management</h6>
                        </div>
                    </div>
                </div>

                @vite('resources/js/hrms/modules/paycheck/inv_forms_mgmt/InvFormsMgmt.js')
                <div id="vjs_invforms_mgmt"></div>
            </div>
         </div>
@endsection
