@extends('layouts.master')
@section('title')
    @lang('translation.dashboards')
@endsection
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/payRoll.css') }}">
@endsection
@section('content')

    <div class="cotainer-fluid ">
        <div class="card top-line mb-0">
            <div class="card-body">
                <h6 class="mb-3">Payroll Progress</h6>
                <div class="card card-body mb-0">
                    <ul class="timeline">
                        <li>
                            <div class="circle-line">
                                <div class="circle-inner active">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="prograssAct_inAct">
                                <span class="prograss_month">Apr</span>
                                <span class="prograss_month">2022</span>
                            </div>
                        </li>
                        <li>
                            <div class="circle-line ">
                                <div class="circle-inner active">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="prograssAct_inAct">
                                <span class="prograss_month">May</span>
                                <span class="prograss_month">2022</span>
                            </div>
                        </li>
                        <li>
                            <div class="circle-line ">
                                <div class="circle-inner active">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="prograssAct_inAct">
                                <span class="prograss_month">Jun</span>
                                <span class="prograss_month">2022</span>
                            </div>
                        </li>
                        <li>
                            <div class="circle-line">
                                <div class="circle-inner active">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="prograssAct_inAct">
                                <span class="prograss_month">July</span>
                                <span class="prograss_month">2022</span>
                            </div>
                        </li>
                        <li>
                            <div class="circle-line">
                                <div class="circle-inner active">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="prograssAct_inAct">
                                <span class="prograss_month">Aug</span>
                                <span class="prograss_month">2022</span>
                            </div>
                        </li>
                        <li>
                            <div class="circle-line">
                                <div class="circle-inner active">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="prograssAct_inAct">
                                <span class="prograss_month">Sep</span>
                                <span class="prograss_month">2022</span>
                            </div>
                        </li>
                        <li>
                            <div class="circle-line">
                                <div class="circle-inner active">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="prograssAct_inAct">
                                <span class="prograss_month">Oct</span>
                                <span class="prograss_month">2022</span>
                            </div>
                        </li>
                        <li>
                            <div class="circle-line inActive">
                                <div class="circle-inner prograss">
                                    <i class="fa fa-ellipsis-h"></i>

                                </div>
                            </div>
                            <div class="prograssAct_inAct">
                                <span class="prograss_month">Nov</span>
                                <span class="prograss_month">2022</span>
                            </div>
                        </li>
                        <li>
                            <div class="circle-line inActive">
                                <div class="circle-inner ">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="prograssAct_inAct">
                                <span class="prograss_month">Dec</span>
                                <span class="prograss_month">2022</span>
                            </div>
                        </li>
                        <li>
                            <div class="circle-line inActive">
                                <div class="circle-inner ">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="prograssAct_inAct">
                                <span class="prograss_month">Jan</span>
                                <span class="prograss_month">2023</span>
                            </div>
                        </li>
                        <li>
                            <div class="circle-line inActive">
                                <div class="circle-inner">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="prograssAct_inAct">
                                <span class="prograss_month">Feb</span>
                                <span class="prograss_month">2023</span>
                            </div>
                        </li>
                        <li>
                            <div class="circle-line inActive">
                                <div class="circle-inner">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="prograssAct_inAct">
                                <span class="prograss_month">Mar</span>
                                <span class="prograss_month">2023</span>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card card-body">
                            <h6 class="mb-3">Oct - 2022<span class="f-13">(31 Days)</span></h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card  box_shadow_0 border-rtb left-line w-100">
                                        <div class="card-body text-center">
                                            <p class="text-ash-medium mb-2 f-13">Total Active Employees</p>
                                            <h5 class="mb-0">152</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card  box_shadow_0 border-rtb left-line w-100">
                                        <div class="card-body text-center">
                                            <p class="text-ash-medium mb-2 f-13">Calendar Days</p>
                                            <h5 class="mb-0">31</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card  box_shadow_0 border-rtb left-line w-100">
                                        <div class="card-body text-center">
                                            <p class="text-ash-medium mb-2 f-13">Total Active Employees</p>
                                            <h5 class="mb-0">152/152</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card  box_shadow_0 border-rtb left-line w-100">
                                <div class="card-body text-center">
                                    <div class="d-flex justify-content-between">
                                        <div class="">
                                            <p class="text-ash-medium mb-2 f-13">Total Payroll Cost</p>
                                            <h5 class="mb-0">INR 1,15,91,555</h5>
                                        </div>
                                        <div class="f-20">=</div>
                                        <div class="">
                                            <p class="text-ash-medium mb-2 f-13">Employee Deposit</p>
                                            <h5 class="mb-0">INR 54,00,000</h5>
                                        </div>
                                        <div class="f-20">+</div>
                                        <div class="">
                                            <p class="text-ash-medium mb-2 f-13">Total Deductions</p>
                                            <h5 class="mb-0">INR 26,91,555</h5>
                                        </div>
                                        <div class="f-20">+</div>
                                        <div class="">
                                            <p class="text-ash-medium mb-2 f-13">Total contributions</p>
                                            <h5 class="mb-0">INR 35,00,00</h5>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card " style="min-height: 284px;height:284px;overflow-y:auto;">
                            <div class="card-body">
                                <h6 class="pb-3 border-bottom ">Activity</h6>

                                <ul class="activity_log list-unstyled">
                                    {{-- <li>
                                        <div class="row">
                                            <div class="col-2">

                                            </div>
                                            <div class="col-8">

                                            </div>
                                            <div class="col-2">

                                            </div>
                                        </div>

                                    </li> --}}
                                    <li class=" p-1 w-100">
                                        <div class="row w-100 m-0    page-header-user-dropdown" data-userid="1">
                                            <div class="user-profile col-2  activity_shortname">
                                                <span class="text-white">AU</span>
                                            </div>
                                            <div
                                                class="user_content col-6 text-start d-flex  align-items-center flex-column">
                                                <p class="fw-bold text-primary f-13">Augustin</p>
                                                <p class="fw-bold text-muted f-10">CEO</p>
                                            </div>
                                            <div class="col-4 text-end pe-0">
                                                <p class="fw-bold text-muted f-10">Nov 8,4:10pm</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h6 class="mb-3">Run Payroll</h6>
                <div class="card card-body mb-0">
                    <div class="arrow-steps clearfix d-flex justify-content-center mb-5">
                        <div class="step current border-start-radius">
                            <span>
                                <span class="svg-algin-crtly">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-calendar-date" viewBox="0 0 16 16">
                                        <path
                                            d="M6.445 11.688V6.354h-.633A12.6 12.6 0 0 0 4.5 7.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675zm1.188-1.305c.047.64.594 1.406 1.703 1.406 1.258 0 2-1.066 2-2.871 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684zm2.953-2.317c0 .696-.559 1.18-1.184 1.18-.601 0-1.144-.383-1.144-1.2 0-.823.582-1.21 1.168-1.21.633 0 1.16.398 1.16 1.23z" />
                                        <path
                                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                                    </svg>
                                </span>Leave Attendance
                            </span>
                        </div>
                        <div class="step current">
                            <span>
                                <span class="svg-algin-crtly">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-gift-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M3 2.5a2.5 2.5 0 0 1 5 0 2.5 2.5 0 0 1 5 0v.006c0 .07 0 .27-.038.494H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h2.038A2.968 2.968 0 0 1 3 2.506V2.5zm1.068.5H7v-.5a1.5 1.5 0 1 0-3 0c0 .085.002.274.045.43a.522.522 0 0 0 .023.07zM9 3h2.932a.56.56 0 0 0 .023-.07c.043-.156.045-.345.045-.43a1.5 1.5 0 0 0-3 0V3zm6 4v7.5a1.5 1.5 0 0 1-1.5 1.5H9V7h6zM2.5 16A1.5 1.5 0 0 1 1 14.5V7h6v9H2.5z" />
                                    </svg>
                                </span>Bonus, Salary Revisions
                            </span>
                        </div>
                        <div class="step current">
                            <span>
                                <span class="svg-algin-crtly">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
                                        <path
                                            d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z" />
                                    </svg>
                                </span>Salaries on Hold
                            </span>
                        </div>
                        <div class="step">
                            <span>
                                <span class="svg-algin-crtly">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                        <path fill-rule="evenodd"
                                            d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                                    </svg>
                                </span>Salaries on Hold
                            </span>
                        </div>
                        <div class="step">
                            <span>
                                <span class="svg-algin-crtly">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-ui-checks-grid" viewBox="0 0 16 16">
                                        <path
                                            d="M2 10h3a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1zm9-9h3a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-3a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zm0 9a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-3zm0-10a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h3a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2h-3zM2 9a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h3a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H2zm7 2a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-3a2 2 0 0 1-2-2v-3zM0 2a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm5.354.854a.5.5 0 1 0-.708-.708L3 3.793l-.646-.647a.5.5 0 1 0-.708.708l1 1a.5.5 0 0 0 .708 0l2-2z" />
                                    </svg>
                                </span>Reimbursement
                            </span>
                        </div>
                        <div class="step border-end-radius">
                            <span>
                                <span class="svg-algin-crtly">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-calendar-date" viewBox="0 0 16 16">
                                        <path
                                            d="M6.445 11.688V6.354h-.633A12.6 12.6 0 0 0 4.5 7.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675zm1.188-1.305c.047.64.594 1.406 1.703 1.406 1.258 0 2-1.066 2-2.871 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684zm2.953-2.317c0 .696-.559 1.18-1.184 1.18-.601 0-1.144-.383-1.144-1.2 0-.823.582-1.21 1.168-1.21.633 0 1.16.398 1.16 1.23z" />
                                        <path
                                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                                    </svg>
                                </span>Override<span class="f-12">(PT, ESI, TDS, LWF)</span>
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-4 col-sm-12 col-xl-4 col-xxl-4 col-md-6 mb-3">
                            <a href="#">
                                <div class="card parRoll_widget mb-0">
                                    <div class="card-body py-1">
                                        <div class="row">
                                            <div class="col-2 calendar_icon_container">
                                                <div class="col-2 calendar_icon-1">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div class="col-10">
                                                <p class="tittle">Leaves, Attendance & Daily Wages</p>
                                                <p class="sub_cont">Last Changes on Oct 03, 2022, (12:33 pm) By Harpitha
                                                    Reddy
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-4 col-sm-12 col-xl-4 col-xxl-4 col-md-6 mb-3">
                            <a href="#">
                                <div class="card parRoll_widget mb-0">
                                    <div class="card-body py-1">
                                        <div class="row">
                                            <div class="col-2 calendar_icon_container">
                                                <div class="col-auto calendar_icon-2">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div class="col-10">
                                                <p class="tittle">Bonus, Salary Revision & Overtime</p>
                                                <p class="sub_cont">Last Changes on Oct 03, 2022, (12:33 pm) By Harpitha
                                                    Reddy
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-sm-12 col-xl-4 col-xxl-4 col-md-6 mb-3">
                            <a href="#">
                                <div class="card parRoll_widget mb-0">
                                    <div class="card-body py-1">
                                        <div class="row">
                                            <div class="col-2 calendar_icon_container">
                                                <div class="col-auto calendar_icon-3">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div class="col-10">
                                                <p class="tittle">Salaries on Hold & Arrears</p>
                                                <p class="sub_cont">Last Changes on Oct 03, 2022, (12:33 pm) By Harpitha
                                                    Reddy
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-sm-12 col-xl-4 col-xxl-4 col-md-6 mb-3">
                            <a href="#">
                                <div class="card parRoll_widget mb-0">
                                    <div class="card-body py-1">
                                        <div class="row">
                                            <div class="col-2 calendar_icon_container">
                                                <div class=" col-auto calendar_icon-4">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div class="col-10">
                                                <p class="tittle">Leaves, Attendance & Daily Wages</p>
                                                <p class="sub_cont">Last Changes on Oct 03, 2022, (12:33 pm) By Harpitha
                                                    Reddy
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-sm-12 col-xl-4 col-xxl-4 col-md-6 mb-3">
                            <a href="#">
                                <div class="card parRoll_widget mb-0">
                                    <div class="card-body py-1">
                                        <div class="row">
                                            <div class="col-2 calendar_icon_container">
                                                <div class="col-auto calendar_icon-5">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div class="col-10">
                                                <p class="tittle">Bonus, Salary Revision & Overtime</p>
                                                <p class="sub_cont">Last Changes on Oct 03, 2022, (12:33 pm) By Harpitha
                                                    Reddy
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-sm-12 col-xl-4 col-xxl-4 col-md-6 mb-3">
                            <a href="#">
                                <div class="card parRoll_widget mb-0">
                                    <div class="card-body py-1">
                                        <div class="row">
                                            <div class="col-2 calendar_icon_container">
                                                <div class="col-auto calendar_icon-6">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div class="col-10">
                                                <p class="tittle">Salaries on Hold & Arrears</p>
                                                <p class="sub_cont">Last Changes on Oct 03, 2022, (12:33 pm) By Harpitha
                                                    Reddy
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="text-end">
                        <button class="btn-border-orange me-2 btn">Preview Run PayRoll</button>
                        <button class="btn-border-orange me-2 btn">Preview all PayRoll</button>
                        <button class="btn-orange btn">Finalize PayRoll</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/gridjs/gridjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/dashboard-projects.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            if (document.getElementById("view_employees-table")) {
                const grid = new gridjs.Grid({
                    columns: [{
                            id: 'month',
                            name: 'Upcoming months',

                        },
                        {
                            id: 'estimated',
                            name: 'Estimated Employee Cost',
                        },
                        {
                            id: 'compensation',
                            name: 'Compensation Cost',
                        },
                        {
                            id: 'pay',
                            name: 'Fix Pay',
                        },
                        {
                            id: 'bonus',
                            name: 'Bouns',
                        },
                        {
                            id: 'others',
                            name: 'Others',
                        },
                        {
                            id: 'final',
                            name: 'Final Cost',
                        }
                    ],
                    data: [
                        // {
                        //     name: 'John',
                        //     email: 'john@example.com',
                        //     phoneNumber: '(353) 01 222 3333'
                        // },
                        // {
                        //     name: 'Mark',
                        //     email: 'mark@gmail.com',
                        //     phoneNumber: '(01) 22 888 4444'
                        // },
                    ],
                    pagination: {
                        limit: 10
                    },
                    sort: true,
                    search: true,
                }).render(document.getElementById("view_employees-table"));
            }
        });
    </script>
@endsection
