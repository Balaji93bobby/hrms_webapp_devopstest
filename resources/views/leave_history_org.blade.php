@extends('layouts.master')
@section('title')
    @lang('translation.dashboards')
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/calendar-vanila.css') }}">
    <script src="{{ URL::asset('assets/js/calendar-vanila.js') }}" defer></script>
    <link href="{{ URL::asset('assets/css/attendance.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />



    <style>

    </style>
@endsection
@endsection
@section('content')
@component('components.attendance_breadcrumb')
    @slot('li_1')
    @endslot
@endcomponent


<div class="leave_settings-wrapper">
    <div class="card  left-line mb-3">
        <div class="card-body px-2 py-2">
            <div class="row ">
                <div class="col-6 d-flex align-items-center">
                    <h6 class="">Leave </h6>
                </div>
                <div class="col-6 text-end">

                    <div class="d-flex justify-content-end">
                        <div class="input-group  w-50 me-2">
                            <label class="input-group-text " for="inputGroupSelect01"><i
                                    class="fa fa-calendar text-primary " aria-hidden="true"></i></label>
                            <select class="form-select btn-line-primary" id="inputGroupSelect01">
                                <option selected>FY 2022-23</option>

                            </select>
                        </div>
                        <div>
                            <button class="btn btn-orange" type="button">
                                Leave Policy Explanation
                            </button>
                        </div>

                    </div>


                </div>

            </div>
        </div>
    </div>

    <div class="card mb-0">
        <div class="card-body">
            <div class="leave-history">
                <h6 class="mb-2">Organization Leave history</h6>
                {{-- <div class="card">
                <div class="card-body"> --}}
                <div class="table-responsive">
                    <div id="table_leaveHistory"></div>
                </div>
                {{-- </div>
            </div> --}}
            </div>

        </div>


        <div id="leave_availed-modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable  modal-xl" role="document">
                <div class="modal-content top-line">
                    <div class="modal-header py-2 new-role-header border-0 d-flex align-items-center">
                        <h6 class="modal-title mb-1 text-primary" style="border-bottom:5px solid #d0d4e2;">
                        </h6>
                        <button type="button" class="close outline-none bg-transparent border-0 h3"
                            data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex mb-2 justify-content-between ">
                            <div class="d-flex">
                                <button class="btn btn-orange me-2"><i class="fa fa-filter"
                                        aria-hidden="true"></i></button>
                                <button class="btn btn-border-primary me-2">Employee</button>
                                <button class="btn btn-border-primary me-2">Department</button>
                                <button class="btn btn-border-primary me-2">Location</button>
                                <button class="btn btn-border-primary me-2">Job Title</button>
                                <button class="btn btn-border-primary me-2">Total:20</button>
                                <label for=""></label>
                            </div>

                            <div class="input-group  w-25 me-2">
                                <label class="input-group-text " for="inputGroupSelect01"><i
                                        class="fa fa-calendar text-primary " aria-hidden="true"></i></label>
                                <select class="form-select btn-line-primary" id="inputGroupSelect01">
                                    <option selected>FY 2022-23</option>

                                </select>
                            </div>
                        </div>
                        <div id="table_leaveHistory">



                        </div>


                    </div>
                </div>
            </div>
        </div>

        <div id="leave_balance-modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable  modal-xl" role="document">
                <div class="modal-content top-line">
                    <div class="modal-header py-2 new-role-header border-0 d-flex align-items-center">
                        <h6 class="modal-title mb-1 text-primary" style="border-bottom:5px solid #d0d4e2;">
                        </h6>
                        <button type="button" class="close outline-none bg-transparent border-0 h3"
                            data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex mb-2 justify-content-between ">
                            <div class="d-flex">
                                <button class="btn btn-orange me-2"><i class="fa fa-filter"
                                        aria-hidden="true"></i></button>
                                <button class="btn btn-border-primary me-2">Employee</button>
                                <button class="btn btn-border-primary me-2">Department</button>
                                <button class="btn btn-border-primary me-2">Location</button>
                                <button class="btn btn-border-primary me-2">Job Title</button>
                                <button class="btn btn-border-primary me-2">Total:20</button>
                                <label for=""></label>
                            </div>

                            <div class="input-group  w-25 me-2">
                                <label class="input-group-text " for="inputGroupSelect01"><i
                                        class="fa fa-calendar text-primary " aria-hidden="true"></i></label>
                                <select class="form-select btn-line-primary" id="inputGroupSelect01">
                                    <option selected>FY 2022-23</option>

                                </select>
                            </div>
                        </div>
                        <div id="viewEmp_history_balance_table"></div>


                    </div>
                </div>
            </div>
        </div>



        <div id="leavepending_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable  modal-lg" role="document">
                <div class="modal-content top-line">
                    <div class="modal-header py-2 new-role-header border-0 d-flex align-items-center">
                        <h6 class="modal-title mb-1 text-primary" style="border-bottom:5px solid #d0d4e2;">
                            Pending Request</h6>
                        <button type="button" class="close outline-none bg-transparent border-0 h3"
                            data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="show_message d-flex justify-content-center align-items-center">
                            <h6 class="text-muted">No Request Pending</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>





        {{--  --}}
        <div id="leaveApply_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable  modal-xl" role="document">
                <div class="modal-content top-line">
                    <div class="modal-header py-2 new-role-header border-0 d-flex align-items-center">
                        <h6 class="modal-title mb-1 text-primary" style="border-bottom:5px solid #d0d4e2;">
                            Leave Request</h6>
                        <button type="button" class="close outline-none bg-transparent border-0 h3"
                            data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card top-line mb-3">
                            <div class="card-body">
                                <div class="row">
                                    {{-- <div class="col-4 d-flex col-sm-12 col-md-6 col-xl-4 col-xxl-4 col-lg-4">
                                    <div class="card w-100 left-line">
                                        <div class="card-body">
                                            <p class="text-muted mb-1 fw-bold text-center">Casual Leave</p>
                                            <h6 class="text-center">10<span class="f-12">days</span> </h6>
                                            <div class="alert mb-0 alert-danger py-1 d-flex align-items-center"
                                                role="alert">
                                                <div class="d-flex justify-content-center">
                                                    <i class="text-warning fw-bold f-10 fa fa-warning me-1">
                                                    </i><span class=" f-10 text-muted "> Lorem ipsum
                                                        dolor sit amet.Lorem ipsum
                                                        dolor sit amet.
                                                        Lorem ipsum
                                                        dolor sit amet.
                                                        Lorem ipsum
                                                        dolor sit amet.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                    <div class="col-4 d-flex col-sm-12 col-md-6 col-xl-4 col-xxl-4 col-lg-4">
                                        <div class="card w-100 left-line">
                                            <div class="card-body">
                                                <p class="text-muted mb-1 fw-bold text-center">Sick Leave</p>
                                                <h6 class="text-center">10<span class="f-12">days</span> </h6>
                                                <div class="alert mb-0 alert-danger py-1 d-flex align-items-center"
                                                    role="alert">
                                                    <div class="d-flex justify-content-center">
                                                        <i class="text-warning fw-bold f-10 fa fa-warning me-1">
                                                        </i><span class=" f-10 text-muted "> Employees are eligible for
                                                            one
                                                            day of SL/CL on the same month on which he/she joins the
                                                            company, but the only criteria are he/she should join before
                                                            15
                                                            of the respective months if
                                                            not, the leave for that month will not be provided.</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 d-flex col-sm-12 col-md-6 col-xl-4 col-xxl-4 col-lg-4">
                                        <div class="card w-100 left-line">
                                            <div class="card-body">
                                                <p class="text-muted mb-1 fw-bold text-center">floater Leave</p>
                                                <h6 class="text-center">10<span class="f-12">days</span> </h6>
                                                <div class="alert mb-0 alert-danger py-1 d-flex align-items-center"
                                                    role="alert">
                                                    <div class="d-flex justify-content-center">
                                                        <i class="text-warning fw-bold f-10 fa fa-warning me-1">
                                                        </i><span class=" f-10 text-muted "> Floating holidays are paid
                                                            vacation days that employees can schedule themselves. They
                                                            are
                                                            mostly used by employees who celebrate cultural or religious
                                                            holidays not included in the set of ten federally recognized
                                                            paid holidays</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-4 d-flex col-sm-12 col-md-6 col-xl-4 col-xxl-4 col-lg-4">
                                        <div class="card w-100 left-line">
                                            <div class="card-body">
                                                <p class="text-muted mb-1 fw-bold text-center">Paternity Leave</p>
                                                <h6 class="text-center">10<span class="f-12">days</span> </h6>
                                                <div class="alert mb-0 alert-danger py-1 d-flex align-items-center"
                                                    role="alert">
                                                    <div class="d-flex justify-content-center">
                                                        <i class="text-warning fw-bold f-10 fa fa-warning me-1">
                                                        </i><span class=" f-10 text-muted ">It provides 15 days of
                                                            leave as
                                                            paternity leave. It is to be provided to employees who have
                                                            less
                                                            than two surviving children. This leave can be availed for
                                                            15
                                                            days either before or within 6 months from the date of
                                                            delivery
                                                            of the child.</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 d-flex col-sm-12 col-md-6 col-xl-4 col-xxl-4 col-lg-4">
                                        <div class="card w-100 left-line">
                                            <div class="card-body">
                                                <p class="text-muted mb-1 fw-bold text-center">Maternity Leave</p>
                                                <h6 class="text-center">10<span class="f-12">days</span> </h6>
                                                <div class="alert mb-0 alert-danger py-1 d-flex align-items-center"
                                                    role="alert">
                                                    <div class="d-flex justify-content-center">
                                                        <i class="text-warning fw-bold f-10 fa fa-warning me-1">
                                                        </i><span class=" f-10 text-muted ">The Maternity Benefit Act
                                                            provides that a woman will be paid maternity benefit at the
                                                            rate
                                                            of her average daily wage in the three months preceding her
                                                            maternity leave. However, the woman needs to have worked for
                                                            the
                                                            employer for at least 80 days in the 12 months preceding the
                                                            date of her expected delivery</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 d-flex col-sm-12 col-md-6 col-xl-4 col-xxl-4 col-lg-4">
                                        <div class="card w-100 left-line">
                                            <div class="card-body">
                                                <p class="text-muted mb-1 fw-bold text-center">Earned Leave</p>
                                                <h6 class="text-center">10<span class="f-12">days</span> </h6>
                                                <div class="alert mb-0 alert-danger py-1 d-flex align-items-center"
                                                    role="alert">
                                                    <div class="d-flex justify-content-center">
                                                        <i class="text-warning fw-bold f-10 fa fa-warning me-1">
                                                        </i><span class=" f-10 text-muted ">Earned Leave will be
                                                            accrued
                                                            every month. i. e 1 day per month</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>


                        <!-- MODEL : Request leave -->
                        <div id="modal_request_leave" class="card top-line">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-8 col-sm-12 col-lg-8 col-xxl-8 col-md-12">
                                        <div class="row mb-3">
                                            <div class="col-md-6 text-md-start mb-md-0 mb-3">
                                                <h6 class=" mb-1">Set range</h6>
                                            </div>


                                            <div class="col-md-6 text-end mb-md-0 mb-3">
                                                <select name="" id="leave_type_id"
                                                    class="form-select outline-none">
                                                    <option value="" selected hidden disabled>Choose Leave
                                                    </option>
                                                    <option value="1">Sick Leave</option>
                                                    <option value="2">LOP Leave</option>
                                                    <option value="3">Casual Leave</option>
                                                    <option value="4">Compensatory Leave</option>
                                                    <option value="5">Flexi day-off Leave</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-4 text-md-start mb-md-0 mb-3">
                                                <label class="fw-bold">Start Date</label>
                                                <input type="datetime-local" id="start_date"
                                                    class="form-control outline-none border-0 shadow-lite">
                                            </div>
                                            <div class="col-md-4 text-md-center mb-md-0 ">
                                                <p class="fw-bold  text-muted">Total Days</p>
                                                <span class="shadow-lite mt-3">-</span>
                                            </div>
                                            <div class="col-md-4 text-md-end ">
                                                <label class="fw-bold">End Date</label>
                                                <input type="datetime-local" id="end_date"
                                                    class="form-control outline-none border-0 shadow-lite">
                                            </div>
                                        </div>
                                        <textarea id="leave_reason" placeholder="Reason here..." class="w-100 outline-none border-0 shadow-lite form-control"
                                            rows="4" style=""></textarea>
                                        <div class="py-2" style="border-bottom: 1px solid #cecece;"></div>
                                        <h6 class="modal-sub-title py-2">Notify to</h6>
                                        <div class="row mb-3">
                                            <div>

                                                <select class="" name="notifications_users_id[]"
                                                    id="notifications_users_id" multiple="multiple">
                                                    @if (!empty($allEmployeesList))
                                                        @foreach ($allEmployeesList as $employeeData)
                                                            <option value="{{ $employeeData->id }}">
                                                                {{ $employeeData->name }}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="">Select Employees</option>
                                                    @endif
                                                </select>


                                            </div>
                                        </div>
                                        <div class="text-center text-md-end">
                                            <button type="button" class="btn btn-border-primary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="button" id="btn_request_leave"
                                                class="btn btn-primary">Request
                                                Leave</button>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-12 col-lg-4 col-xxl-4 col-md-12  mt-md-3 mt-sm-3">

                                        <div class="calendar-wrapper card mb-4 border-0">
                                            <div class="card-body p-0">
                                                <div class="_wrapper">
                                                    <div class="h-100  _container-calendar">
                                                        <div
                                                            class="_button-container-calendar d-flex align-items-center justify-content-between">
                                                            <button id="_previous" onclick="previous()"
                                                                class="previous"><i
                                                                    class="fa fa-chevron-left"></i></button>
                                                            <h6 id="_monthAndYear" class="_monthAndYear"></h6>
                                                            <button id="_next" onclick="next()" class="next"><i
                                                                    class="fa fa-chevron-right"></i></button>
                                                        </div>
                                                        <table class="_table-calendar" id="_calendar" data-lang="en">


                                                            <thead id="_thead-month"></thead>
                                                            <tbody id="_calendar-body">

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="leave_det_calendar">
                                            <div class="row">
                                                <div class="col-6">
                                                    <p class="casual_leave">Casual Leave</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="sick_leave">Sick Leave</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="floater_leave">Floater Leave</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="maternity_leave">Maternity Leave</p>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>





        <div id="leaveDetails_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable  modal-lg" role="document">
                <div class="modal-content top-line">
                    <div class="modal-header py-2 new-role-header border-0 d-flex align-items-center">
                        <h6 class="modal-title mb-1 text-primary" style="border-bottom:5px solid #d0d4e2;">
                            Leave Request Details</h6>
                        <button type="button" class="close outline-none bg-transparent border-0 h3"
                            data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="card">
                            <div class="card-body">

                                <div class="d-flex profile-wrapper">
                                    <div class="profile-img d-flex align-items-center justify-content-center me-3">
                                        <span>GN</span>
                                    </div>

                                    <div class="content d-flex flex-column align-items-center justify-content-center">
                                        <p class="text-primary fw-bold">Augustin</p>
                                        <p class="text-muted">Requested on Sep 21,2022 </p>
                                    </div>


                                </div>


                                <hr class="text-muted p-0">

                                <div class="d-flex ">
                                    <div
                                        class="date-wrapper shadow-lite d-flex flex-column justify-content-center me-2">

                                        <div class="month text-center bg-primary text-white">
                                            Apr
                                        </div>
                                        <div class="date text-center fw-bold f-14 text-primary ">
                                            22
                                        </div>
                                        <div class="day text-center f-12 fw-bold text-muted ">

                                            Fri
                                        </div>

                                    </div>
                                    <div class="content-det">
                                        <h6>1 Day Sick Leave</h6>
                                        <p>Leave Ended 40 days ago</p>
                                        <p>No teammates are no leave on this day</p>
                                    </div>
                                </div>

                                <hr class="text-muted p-0">
                                <h6 class="modal-sub-title py-2">Notify to</h6>
                                <div class="row mb-3">
                                    <div class="col-6 mb-md-0 mb-3">
                                        <div class="profile-wrapper center">
                                            <div class="profile-body">
                                                <img src="http://images.equipboard.com/uploads/user/image/524/big_calvin-harris.jpg?v=1466072866"
                                                    alt="" />
                                                <div class="profile-details">
                                                    <p>Dillip Kumar</p>
                                                    <h5 class="description">Designation</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-md-0 mb-3">
                                        <div class="profile-wrapper center">
                                            <div class="profile-body">
                                                <img src="http://images.equipboard.com/uploads/user/image/524/big_calvin-harris.jpg?v=1466072866"
                                                    alt="" />
                                                <div class="profile-details">
                                                    <p>Praveen</p>
                                                    <h5 class="description">Designation</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <hr class="text-muted p-0">
                                <h6 class="modal-sub-title py-2">Approved by</h6>
                                <div class="row mb-3">
                                    <div class="col-6 mb-md-0 mb-3">
                                        <div class="profile-wrapper center">
                                            <div class="profile-body">
                                                <img src="http://images.equipboard.com/uploads/user/image/524/big_calvin-harris.jpg?v=1466072866"
                                                    alt="" />
                                                <div class="profile-details">
                                                    <p>Dillip Kumar</p>
                                                    <h5 class="description">Designation</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="text-muted p-0">
                                <h6 class="modal-sub-title py-2">Approved by</h6>
                                <div class="row mb-3">
                                    <div class="col-12 mb-md-0 mb-3">
                                        <textarea placeholder="Add Comment" class="form-control outline-none border-0 shadow-lite" name=""
                                            id="" cols="30" rows="3"></textarea>

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12 mb-md-0 mb-3 text-end">
                                        <button class="btn btn-orange">Post</button>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>

</div>
@endsection

@section('script')
<script src="{{ URL::asset('assets/libs/gridjs/gridjs.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/pages/dashboard-projects.init.js') }}"></script>
<script src="{{ URL::asset('/assets/premassets/js/calendar.min.js') }}"></script>
<script src="{{ URL::asset('/assets/premassets/js/calendar.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    var leavetypes_array = <?php echo json_encode(getAllLeaveTypes()); ?>;
    var employeesList_array = <?php echo json_encode($allEmployeesList); ?>;



    $(document).ready(function() {
        $('#notifications_users_id').select2({
            dropdownParent: $("#modal_request_leave"),
            width: '100%'
        });

        // $(document).on('#select-reviewer:open', () => {
        //         $('.select2-search__field').focus();
        //     });

        $('#btn_request_leave').on('click', function(e) {
            console.log("Selected Button : " + $(this).attr('name'));

            $.ajax({
                url: "{{ url('attendance-applyleave') }}",
                type: "POST",
                dataType: "json",
                data: {
                    'user_id': $('#leave_type_id').val(),
                    'start_date': $('#start_date').val(),
                    'end_date': $('#end_date').val(),
                    'leave_reason': $('#leave_reason').val(),
                    'leave_type_id': $('#leave_type_id').val(),
                    'notifications_users_id': $('#notifications_users_id').val(),
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    if (data.status == "success") {
                        alert(data.message + " \n " + data.mail_status);
                    } else {
                        alert("Leave request failed. Contact your Admin");
                    }
                },
                error: function(data) {


                }
            });
        });


        if (document.getElementById("table_leaveHistory")) {
            const grid = new gridjs.Grid({
                columns: [

                    {
                        id: 'user_id',
                        name: 'Employee Name',
                        hidden: true,
                        formatter: function formatter(cell) {
                            return gridjs.html(cell);
                        }
                    },
                    {
                        id: 'leave_type_id',
                        name: 'Leave Type',
                        formatter: function formatter(cell) {

                            for (var i = 0; i < leavetypes_array.length; i++) {
                                if (leavetypes_array[i].id == cell)
                                    return gridjs.html(leavetypes_array[i].leave_type);
                            }
                        }
                    },
                    {
                        id: 'start_date',
                        name: 'Start Date',
                    },

                    {
                        id: 'end_date',
                        name: 'End Date',
                    },

                    {
                        id: 'leave_reason',
                        name: 'Leave Reason',
                    },
                    {
                        id: 'reviewer_user_id',
                        name: 'Reviewer Name',
                        formatter: function formatter(cell) {

                            for (var i = 0; i < employeesList_array.length; i++) {
                                if (employeesList_array[i].id == cell)
                                    return gridjs.html(employeesList_array[i].name);
                            }
                        }
                    },
                    {
                        id: 'reviewer_comments',
                        name: 'Reviewer Comments',
                    },
                    {
                        id: 'status',
                        name: 'Status',
                        //     formatter: (cell, row) => {
                        //         return h('button', {
                        //             className: 'py-2 mb-4 px-4 border rounded-md text-white bg-blue-600',
                        //             onClick: () => alert(
                        //                 `Editing "${row.cells[0].data}" "${row.cells[1].data}"`
                        //                 )
                        //         }, 'Edit');

                        // },
                    },
                    {
                        id: 'actions',
                        name: 'Action',
                        formatter: function formatter(emp) {
                            var htmlcontent = "";

                            // if (leave_history.status == "Pending")
                            //     htmlcontent =
                            //     '<input type="button" value="Activate" onclick="activateEmployee(this)" id="button_activate_"' +
                            //     emp.user_id + '" data-user_id="' + emp.user_id +
                            //     '" class="status btn btn-orange py-1 onboard-employee-btn "></input>';
                            // else
                            //     htmlcontent =
                            //     '<input type="button" value="Activate" class="status btn btn-orange py-1 onboard-employee-btn disabled"></input>';
                            // <button class="btn btn-orange" data-bs-target="#leaveDetails_modal" data-bs-toggle="modal">
                            //       <i class="fa  fa-sticky-note-o"></i>
                            //     </button>

                            htmlcontent =
                                '<input type="button" value="View" class="status btn btn-orange py-1 onboard-employee-btn " data-bs-target="#leaveDetails_modal" data-bs-toggle="modal" disabled></input>';

                            return gridjs.html(htmlcontent);
                        }
                    },
                ],
                pagination: {
                    limit: 10
                },
                sort: true,
                search: true,
                server: {
                    url: '{{ route('fetch-leavehistory',['type'=>'org']) }}',
                    then: data => data.map(
                        leave_history => [
                            leave_history.id,
                            // leave_history.user_id,
                            leave_history.leave_type_id,
                            leave_history.start_date,
                            leave_history.end_date,
                            leave_history.leave_reason,
                            leave_history.reviewer_user_id,
                            //leave_history.notifications_users_id,
                            leave_history.reviewer_comments,
                            leave_history.status,
                            leave_history,

                        ]
                    )
                }
            }).render(document.getElementById("table_leaveHistory"));
        }
    });
</script>
@endsection
