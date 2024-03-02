@extends('layouts.master')

@section('title')
    @lang('translation.dashboards')
@endsection
@section('content')

@vite('resources/js/hrms/modules/configurations/attendance_settings/Attendance_setting_master.js')
<div id="vjs_Attendance_master"></div>


<div class="card" style="margin-top: 20px;">
        <div class="tab-content" id="pills-tabContent">
            @vite('resources/js/hrms/modules/configurations/holidays/Holidays_Lists.js')
            <div id="VJS_holiday_list"></div>
    </div>
</div>


@endsection
