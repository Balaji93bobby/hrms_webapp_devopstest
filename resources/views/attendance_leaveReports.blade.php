@extends('layouts.master')
@section('title')
@lang('translation.dashboards')
@endsection
@section('content')
@component('components.attendance_breadcrumb')
@slot('li_1')
@endslot
@endcomponent


<div class="card top-line">
    <div class="card-body">
        <ul class="nav nav-pills    nav-tabs-dashed" id="pills-tab" role="tablist">
            <li class="nav-item active ember-view mx-4" role="presentation">
                <a class="nav-link active ember-view " id="pills-home-tab" data-bs-toggle="pill" href="" data-bs-target="#leave_report" role="tab" aria-controls="pills-home" aria-selected="true">
                    Leave
                    Reports</a>
            </li>
            <li class="nav-item  ember-view mx-4" role="presentation">
                <a class="nav-link  ember-view " id="pills-home-tab" data-bs-toggle="pill" href="" data-bs-target="#attendance_report" role="tab" aria-controls="" aria-selected="true">
                    Attendance Reports</a>
            </li>

        </ul>

        <div class="tab-content " id="pills-tabContent">
            <div class="tab-pane fade show active" id="leave_report" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="row">
                    <div class="col-6 col-sm-12 col-md-12 col-xxl-6 col-lg-6 col-xl-6">
                        <ul class="list-style-numbered list-style-circle p-4">
                            <li>
                                <a href="">
                                    <p class="listcont">Employees Leave Requests</p>
                                </a>
                                <p class="listsub">Leave request of (current) employees along with approval status, for selected
                                    duration.</p>
                            </li>

                            <li>
                                <a href="">
                                    <p class="listcont">Employees Unplanned Leave Requests</p>
                                </a>
                                <p class="listsub">Unplanned leave request of employees along with approval status, for selected
                                    duration.</p>
                            </li>

                            <li>
                                <a href="">
                                    <p class="listcont">Leave Requests of Relieved Employees</p>
                                </a>
                                <p class="listsub">Leave requests of (relieved/exited) employees along with approval status, for
                                    selected duration.</p>
                            </li>

                            <li>
                                <a href="">
                                    <p class="listcont">Leave Balances of Employees</p>
                                </a>
                                <p class="listsub">Available leave balance of (current) employees in your organization.</p>
                            </li>

                            <li>
                                <a href="">
                                    <p class="listcont">Leave Balances of Relieved Employees</p>
                                </a>
                                <p class="listsub">Available leave balance of (relieved/exited) employees in your organization.
                                </p>
                            </li>

                            <li>
                                <a href="">
                                    <p class="listcont">Leave Consumed</p>
                                </a>
                                <p class="listsub">Segregated employees' leave consumption by leave type, for selected duration.
                                </p>
                            </li>

                            <li>
                                <a href="">
                                    <p class="listcont">Employees with Negative Leave Balance</p>
                                </a>
                                <p class="listsub">List of employees who consumed more than available leave balance.</p>
                            </li>

                            <li>
                                <a href="">
                                    <p class="listcont">Employees Compensatory Off Requests</p>
                                </a>
                                <p class="listsub">Comp-off request of employees along with requested dates & approval status,
                                    for
                                    selected duration.

                                </p>
                            </li>

                            <li>
                                <a href="">
                                    <p class="listcont">Leave Carryover (Imported) - Initial Adjustments</p>
                                </a>
                                <p class="listsub">View leave carryover (last imported) for adjustments.</p>
                            </li>

                        </ul>

                    </div>
                    <!-- 2nd half -->
                    <div class="col-6 col-sm-12 col-md-12 col-xxl-6 col-lg-6 col-xl-6">
                        <ul class="list-style-numbered list-style-circle p-4">
                            <li>
                                <a href="">
                                    <p class="listcont">Leave Consumed (Imported) - Initial Adjustments</p>
                                </a>
                                <p class="listsub">View leave consumed (last imported), for adjustments.</p>
                            </li>
                            <li>
                                <a href="">
                                    <p class="listcont">Employees Leave Balance YTD</p>
                                </a>
                                <p class="listsub">Find out leave balance of employees as of any date during the year.</p>
                            </li>

                            <li>
                                <a href="">
                                    <p class="listcont">Opening and Closing Leave Balances of Employees</p>
                                </a>
                                <p class="listsub">Find out opening, consumed & closing balance of employees for a selected
                                    period.</p>
                            </li>

                            <li>
                                <a href="">
                                    <p class="listcont">Leave Accrued</p>
                                </a>
                                <p class="listsub">Total number of leave that has been accrued during a selected period, for all
                                    employees.</p>
                            </li>

                            <li>
                                <a href="">
                                    <p class="listcont">Leave - Exception Log</p>
                                </a>
                                <p class="listsub">This report only includes exceptions that might have occurred in last 30
                                    days.
                                </p>
                            </li>

                            <li>
                                <a href="">
                                    <p class="listcont">Leave Year End Process Report</p>
                                </a>
                                <p class="listsub">Total number of leave encashed, carry forwarded, or expired as part of year
                                    end
                                    processing.</p>
                            </li>

                            <li>
                                <a href="">
                                    <p class="listcont">Leave/Compensatory-Off Expiry Report</p>
                                </a>
                                <p class="listsub">Total count of leave/compensatory-Off that expired during selected period.
                                </p>
                            </li>

                            <li>
                                <a href="">
                                    <p class="listcont">Year Around Leave Encashment Report</p>
                                </a>
                                <p class="listsub">Leave Encashment request of employees along with approval status, for
                                    selected
                                    duration.</p>
                            </li>

                        </ul>

                    </div>
                </div>

            </div>
            <div class="tab-pane fade " id="attendance_report" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="row">
                    <div class="col-6 col-sm-12 col-md-12 col-xxl-6 col-lg-6 col-xl-6">
                        <ul class="list-style-numbered list-style-circle p-4">
                            <li>
                                <a href="">
                                    <p class="listcont">Working Days & Effective Hours Summary</p>
                                </a>
                                <p class="listsub">Total days worked, including aggregated work hours, days of absence, leave
                                    taken, week-off & holidays.</p>
                            </li>

                            <li>
                                <a href="">
                                    <p class="listcont">Worked on Holidays Summary - Employees Working on Holidays / Week-offs</p>
                                </a>
                                <p class="listsub">Employees who were present at work on a holiday or week-off.</p>
                            </li>

                            <li>
                                <a href="">
                                    <p class="listcont">Attendance Status Report</p>
                                </a>
                                <p class="listsub">See if/when an employee was Present/Absent/On Leave/Week-off, etc. for
                                    selected dates.</p>
                            </li>

                            <li>
                                <a href="">
                                    <p class="listcont">Working Days Summary</p>
                                </a>
                                <p class="listsub">Report showing total Work days, WFH/OD requests, Absent days, Penalizations,
                                    and Leave taken/penalized, etc.

                                </p>
                            </li>

                            <li>
                                <a href="">
                                    <p class="listcont">Attendance Exception Logs</p>
                                </a>
                                <p class="listsub">Any restriction or error that might have occurred when employee was raising
                                    attendance request, such as Adjustment, WFH/ OD, etc.
                                </p>
                            </li>

                        </ul>

                    </div>

                    <!-- 2nd half -->

                    <div class="col-6 col-sm-12 col-md-12 col-xxl-6 col-lg-6 col-xl-6">
                        <ul class="list-style-numbered list-style-circle p-4">
                            <li>
                                <a href="">
                                    <p class="listcont">Employees Time Assignments Report</p>
                                </a>
                                <p class="listsub">Select date range to view assigned shifts/weekly-off to employees.</p>
                            </li>

                            <li>
                                <a href="">
                                    <p class="listcont">Overtime Breakup Details - Employee Day-wise Over Time Breakup Details</p>
                                </a>
                                <p class="listsub">Employees who worked more than designated work hours during the selected date
                                    range as per the assigned overtime policy.
                                </p>
                            </li>

                            <li>
                                <a href="">
                                    <p class="listcont">Overtime Consolidated Hours Report - Employee wise Overtime consolidated
                                        hours</p>
                                </a>
                                <p class="listsub">Find out what has been total Gross, Effective and Overtime work hours of
                                    employees for selected period as per the assigned overtime policy</p>
                            </li>

                            <li>
                                <a href="">
                                    <p class="listcont">Overtime CompOff Details - Employee Day-wise Overtime CompOff Details</p>
                                </a>
                                <p class="listsub">Employees who were awarded comp-off for overtime hours worked as per the
                                    assigned overtime policy.</p>
                            </li>

                            <li>
                                <a href="">
                                    <p class="listcont">Shift Allowance Details - Employee wise Shift Allowance Details</p>
                                </a>
                                <p class="listsub">Employees who were awarded shift allowance for shifts worked as per the
                                    assigned shift allowance policy.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
@section('script')
<script>
</script>
@endsection