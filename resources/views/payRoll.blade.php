@extends('layouts.master')
@section('title')
    @lang('translation.dashboards')
@endsection
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/payRoll.css') }}">
    <link href="{{ URL::asset('assets/css/salary.css') }}" rel="stylesheet">
@endsection
@section('content')

    <div class="cotainer-fluid">
        <div class="card mb-2">
            <div class="py-1 card-body">

                    <ul class="nav nav-pills nav-tabs-dashed">
                        <li class="nav-item text-muted">
                            <a class="nav-link active" data-bs-toggle="tab" href="#analytics">Analytics</a>
                        </li>
                        <li class="nav-item text-muted">
                            <a class="nav-link" data-bs-toggle="tab" href="#compensation_planning">Compensation Planning</a>
                        </li>
                        <li class="nav-item text-muted">
                            <a class="nav-link" data-bs-toggle="tab" href="#budget_estimation">Budget Estimation</a>
                        </li>
                        <li class="nav-item text-muted">
                            <a class="nav-link" data-bs-toggle="tab" href="#compare_compensation_cost">Compare Compensation
                                Cost</a>
                        </li>
                        <li class="nav-item text-muted">
                            <a class="nav-link" data-bs-toggle="tab" href="#employee_competitiveness">Employee
                                Competitiveness</a>
                        </li>
                        <li class="nav-item text-muted">
                            <a class="nav-link" data-bs-toggle="tab" href="#geographical_differentials">Geographical
                                Differetials</a>
                        </li>
                    </ul>

            </div>
        </div>
        <div class="tab-content">
            <div id="analytics" class="tab-pane fade show active">
                <div class="card top-line">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3 col-sm-12 col-xl-3 col-md-4 col-lg-3 d-flex">
                                <div class="card box_shadow_0 border-rtb left-line w-100">
                                    <div class="card-body text-center">
                                        <p class="text-ash-medium mb-2 f-13">Last Salary <span class="text-primary">(Aug
                                                2022)</span></p>
                                        <h5 class="mb-0">-</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-sm-12 col-xl-3 col-md-4 col-lg-3 d-flex">
                                <div class="card box_shadow_0 border-rtb left-line w-100">
                                    <div class="card-body text-center">
                                        <p class="text-ash-medium mb-2 f-13">Upcoming Salary<span class="text-primary">(Sep
                                                2022)</span></p>
                                        <h5 class="mb-0">-</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-sm-12 col-xl-3 col-md-4 col-lg-3 d-flex">
                                <div class="card box_shadow_0 border-rtb  left-line w-100">
                                    <div class="card-body text-center">
                                        <p class="text-ash-medium mb-2 f-13">Upcoming Revisions<span class="text-primary">(3
                                                months)</span></p>
                                        <h5 class="mb-0">-</h5>
                                        <div class="text-right">
                                            <button type="button" class="btn px-2 py-0 border_radius_3 btn-orange"
                                                data-bs-toggle="modal" data-bs-target="#upcomingRevision_modal">
                                                <i class="fa fa-file-text-o"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-sm-12 col-xl-3 col-md-4 col-lg-3 d-flex">
                                <div class="card box_shadow_0 border-rtb  left-line w-100">
                                    <div class="card-body text-center">
                                        <p class="text-ash-medium mb-2 f-13">Pending Revisions</p>
                                        <h5 class="mb-0">-</h5>
                                        <div class="text-right">
                                            <button type="button"
                                                class="btn px-2 py-0 border_radius_3 btn-orange"data-bs-toggle="modal"
                                                data-bs-target="#pendingRevision_modal">
                                                <i class="fa fa-file-text-o"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card top-line mb-0">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-10 col-xl-10 col-md-10 col-lg-10">
                                <h6 class="text-left fw-bold">Compensation Summary</h6>
                            </div>
                            <div class="col-sm-2 col-xl-2 col-md-2 text-end col-lg-2">
                                <select name="" id="" class="form-select border-orange disabled_focus">
                                    <option value="" selected="" hidden="" disabled="">
                                        Aug 20 - Aug 26
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-xl-10 col-md-10 col-lg-10">
                            <ul class="nav nav-pills button_tabs mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#by_department" type="button" role="tab"
                                        aria-controls="pills-home" aria-selected="true">by Department</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#by_location" type="button" role="tab"
                                        aria-controls="pills-profile" aria-selected="false">by Location</button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane show fade active" id="by_department" role="tabpanel"
                                aria-labelledby="pills-profile-tab">

                                <div class="text-center">
                                    <div class="col-md-5 mx-auto">
                                        <img src="{{ URL::asset('assets/images/no_dataFile.svg') }}" class="img-fluid"
                                            alt="user-pic">
                                    </div>
                                    <h4> <span class="text-orange">Sorry !</span> No data</h4>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="by_location" role="tabpanel"
                                aria-labelledby="pills-contact-tab">
                                <div class="text-center">
                                    <div class="col-md-3 mx-auto">
                                        <img src="{{ URL::asset('assets/images/Fingerprint.gif') }}" class="img-fluid"
                                            alt="user-pic">
                                    </div>
                                    <h4> <span class="text-orange">Sorry !</span> No data</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="compensation_planning" class="tab-pane fade ">
                <div class="card top-line mb-0">
                    <div class="card-body">
                        <h6 class="mb-3">Compensation Planning</h6>
                        <p class="mb-3 fw-bold text-muted   f-14">Compensation Cost - Upcoming months</p>
                        <div class="bg-lightsmoke card">
                            <div class="card-body">
                                <div class="text-center h-100 align-items-center d-flex justify-content-center">
                                    {{-- <div class="col-md-3 mx-auto">
                                        <img src="{{ URL::asset('assets/images/Fingerprint.gif') }}" class="img-fluid"
                                            alt="user-pic">
                                    </div> --}}
                                    <h4><span class="text-orange">Sorry..!</span> No data</h4>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card top-line mb-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h6 class="text-left fw-bold mb-3">View Employees</h6>
                            </div>
                            <div class="col-6 text-end">
                                <div class="col-3 ms-auto">
                                    <select name="" id=""
                                        class="form-select border-orange disabled_focus">
                                        <option value="" selected="" hidden="" disabled="">Download as
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 d-flex justify-content-between mb-3">
                            <div class="d-flex space-around-between">
                                <button class="filter-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                                        <path
                                            d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z">
                                        </path>
                                    </svg>
                                </button>
                                <button class="btn selection-btn">Business Unit</button>
                                <button class="btn selection-btn">Department</button>
                                <button class="btn selection-btn">Location</button>
                                {{-- <button class="total-btn">Total <span>40</span></button> --}}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div id="view_employees-table"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="budget_estimation" class="tab-pane fade">
                <div class="card top-line">
                    <div class="card-body">
                        <div class="col-sm-12 col-xl-12 col-md-12 col-lg-12 col-xxl-12">
                            <ul class="nav nav-pills button_tabs mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#new_budget" type="button" role="tab" aria-controls=""
                                        aria-selected="true">New Budget</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="" data-bs-toggle="pill"
                                        data-bs-target="#saved_budget" type="button" role="tab" aria-controls=""
                                        aria-selected="false">Saved Budget Reports</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane show fade active" id="new_budget" role="tabpanel"
                                    aria-labelledby="">
                                    {{-- <div class="text-center">
                                        <div class="col-md-5 mx-auto">
                                            <img src="{{ URL::asset('assets/images/no_dataFile.svg') }}" class="img-fluid"
                                                alt="user-pic">
                                        </div>
                                        <h4> <span class="text-orange">Sorry !</span> No data</h4>
                                    </div> --}}

                                    <div class="newBudget_table" id="newBudget_table"></div>

                                </div>
                                <div class="tab-pane fade" id="saved_budget" role="tabpanel" aria-labelledby="">
                                    <div class="text-center">
                                        <div class="col-md-5 mx-auto">
                                            <img src="{{ URL::asset('assets/images/no_dataFile.svg') }}" class="img-fluid"
                                                alt="user-pic">
                                        </div>
                                        <h4> <span class="text-orange">Sorry !</span> No data</h4>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
            <div id="compare_compensation_cost" class="tab-pane fade">
                <div class="card top-line mb-0">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <h6 class="">Compensation Planning</h6>
                            </div>
                            <div class="col-md-2 text-end">
                                <select name="" id="" class="form-select border-orange disabled_focus">
                                    <option value="" selected="" hidden="" disabled="">Compare by
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="" id="" class="form-select border-orange disabled_focus">
                                    <option value="" selected="" hidden="" disabled="">Aug 20 - Aug 26
                                    </option>
                                </select>
                            </div>
                        </div>
                        {{-- <div class="card box_shadow_0 border-rtb left-line w-100">
                            <div class="card-body text-center">
                                <p class="text-ash-medium mb-2 f-13">Select a business unit to see the employees headcount,
                                    their department, location, planned, compansation cost, etc</p>
                                <p class="text-ash-medium mb-2 f-13">You can select up to 3 business units to compare.</p>

                            </div>
                        </div> --}}
                        {{-- <div class="text-center mb-3">
                            <button class="btn btn-orange">
                                <span style="vertical-align: text-top;">Select Primary</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="svg-custom-iconone bi bi-chevron-down"
                                    viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z">
                                    </path>
                                </svg>
                            </button>
                        </div> --}}
                        <div class="">
                            <div class="">
                                <div class="d-flex justify-content-between mb-3">
                                    <p class="f-14 fw-bold text-primary text-start">ABS(Primary)</p>
                                    <button class="btn btn-orange">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-arrow-down-short" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M8 4a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5A.5.5 0 0 1 8 4z" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 ">
                                        <p class="text-start text-primary mb-3">Overall Headcount</p>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card box_shadow_0 border-rtb left-line w-100 mb-3">
                                                    <div class="card-body text-center">
                                                        <p class="text-ash-medium mb-0 f-13">Department</p>
                                                        <h5 class="mb-0">-</h5>
                                                    </div>
                                                </div>
                                                <div class="card box_shadow_0 border-rtb left-line w-100 mb-3">
                                                    <div class="card-body text-center">
                                                        <p class="text-ash-medium mb-0 f-13">Male</p>
                                                        <h5 class="mb-0">-</h5>
                                                    </div>
                                                </div>
                                                <div class="card box_shadow_0 border-rtb left-line w-100 mb-3">
                                                    <div class="card-body text-center">
                                                        <p class="text-ash-medium mb-0 f-13">Non-binary</p>
                                                        <h5 class="mb-0">-</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card box_shadow_0 border-rtb left-line w-100 mb-3">
                                                    <div class="card-body text-center">
                                                        <p class="text-ash-medium mb-0 f-13">Location</p>
                                                        <h5 class="mb-0">-</h5>
                                                    </div>
                                                </div>
                                                <div class="card box_shadow_0 border-rtb left-line w-100 mb-3">
                                                    <div class="card-body text-center">
                                                        <p class="text-ash-medium mb-0 f-13">Female</p>
                                                        <h5 class="mb-0">-</h5>
                                                    </div>
                                                </div>
                                                <div class="card box_shadow_0 border-rtb left-line w-100 mb-3">
                                                    <div class="card-body text-center">
                                                        <p class="text-ash-medium mb-0 f-13">Undisclosed</p>
                                                        <h5 class="mb-0">-</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 ">
                                        <p class="text-start text-primary mb-3 ">Planned Cost vs Actual Cost</p>
                                        <div class="border-right border-left px-2">
                                            <div class="card box_shadow_0 border-rtb left-line w-100 mb-3">
                                                <div class="card-body text-center">
                                                    <p class="text-ash-medium mb-0 f-13">Planned</p>
                                                    <h5 class="mb-0">-</h5>
                                                </div>
                                            </div>
                                            <div class="card box_shadow_0 border-rtb left-line w-100 mb-3">
                                                <div class="card-body text-center">
                                                    <p class="text-ash-medium mb-0 f-13">Actual</p>
                                                    <h5 class="mb-0">-</h5>
                                                </div>
                                            </div>
                                            <div class="card box_shadow_0 border-rtb left-line w-100 mb-3">
                                                <div class="card-body text-center">
                                                    <p class="text-ash-medium mb-0 f-13">Variance</p>
                                                    <h5 class="mb-0">-</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="d-flex justify-content-between mb-2">
                                            <p class="text-start text-primary ">Planned Compensation Cost</p>
                                            <p style="position: relative;" class="text-end">
                                                <span class="text-primary me-2">Monthly Average</span>
                                                <span style="position: relative;bottom: -6px;">
                                                    <label class="switch-checkbox f-12 text-muted  m-0">
                                                        <input type="checkbox" id="" class="f-13 text-muted"
                                                            checked="">
                                                        <span class="slider-checkbox check-in round"></span>
                                                    </label>
                                                </span>
                                            </p>
                                        </div>

                                        <div class="row">

                                            <div class="col-8 mb-5 d-flex justify-content-center">
                                                <div class="cost_chart">
                                                    <figure class="pie-chart">
                                                        <!-- <figcaption>SVG PIE Chart with CSS animation</figcaption> -->
                                                        <svg viewBox="0 0 63.6619772368 63.6619772368">
                                                            <circle class="pie1" cx="31.8309886184" cy="31.8309886184"
                                                                r="15.9154943092" />
                                                            <!-- <circle class="pie2" cx="31.8309886184" cy="31.8309886184" r="15.9154943092" /> -->
                                                            <circle class="pie3" cx="31.8309886184" cy="31.8309886184"
                                                                r="15.9154943092" />
                                                            <circle class="pie4" cx="31.8309886184" cy="31.8309886184"
                                                                r="15.9154943092" />
                                                        </svg>
                                                    </figure>

                                                </div>
                                            </div>
                                            <div
                                                class="col-4 mb-5 text-center d-flex align-items-center justify-content-center flex-column">
                                                <p class="text-center text-muted fw-bold f-15 ">Total</p>
                                                <h6>-</h6>
                                            </div>

                                            <div class="col-3 text-center ">
                                                <p class="cost_fixed text-muted">Fixed</p>
                                                <p class="text-primary f-13 fw-bold">-</p>
                                            </div>
                                            <div class="col-3 text-center">
                                                <p class="cost_bonus text-muted">Bonus</p>
                                                <p class="text-primary f-13 fw-bold">-</p>

                                            </div>
                                            <div class="col-3 text-center">
                                                <p class="cost_contri text-muted">Contribution</p>
                                                <p class="text-primary f-13 fw-bold">-</p>


                                            </div>
                                            <div class="col-3 text-center">
                                                <p class="cost_other text-muted">Others</p>
                                                <p class="text-primary f-13 fw-bold">-</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mb-3">
                            <button class="btn btn-orange">
                                <span style="vertical-align: text-top;">Select Secondary</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="svg-custom-iconone bi bi-chevron-down"
                                    viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="employee_competitiveness" class="tab-pane fade">


                <div class="card left-line mb-0">

                    <div class="card-body">
                        <h6>Employee Competitiveness</h6>
                        <div class="text-center">
                            <div class="col-md-3 mx-auto">
                                <img src="{{ URL::asset('assets/images/Fingerprint.gif') }}" class="img-fluid"
                                    alt="user-pic">
                            </div>
                            <h4> <span class="text-orange">Sorry..!</span> No data</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div id="geographical_differentials" class="tab-pane fade">


                <div class="card left-line mb-0">

                    <div class="card-body">
                        <h6>Geographical  Competitiveness</h6>
                        <div class="text-center">
                            <div class="col-md-3 mx-auto">
                                <img src="{{ URL::asset('assets/images/Fingerprint.gif') }}" class="img-fluid"
                                    alt="user-pic">
                            </div>
                            <h4> <span class="text-orange">Sorry..!</span> No data</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="upcomingRevision_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable  modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header py-2 new-role-header border-0 d-flex align-items-center">
                        <h6 class="modal-title mb-1 text-primary" style="border-bottom:5px solid #d0d4e2;">Upcoming
                            Revisions</h6>
                        <button type="button" class="close outline-none bg-transparent border-0 h3"
                            data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <div class="col-md-5 mx-auto">
                                <img src="{{ URL::asset('assets/images/Fingerprint.gif') }}" class="img-fluid"
                                    alt="user-pic">
                            </div>
                            <h4> <span class="text-orange">Sorry..!</span> No data</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="pendingRevision_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable  modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header py-2 new-role-header border-0 d-flex align-items-center">
                        <h6 class="modal-title mb-1 text-primary" style="border-bottom:5px solid #d0d4e2;"> Pending
                            Revisions</h6>
                        <button type="button" class="close outline-none bg-transparent border-0 h3"
                            data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <div class="col-md-5 mx-auto">
                                <img src="{{ URL::asset('assets/images/Fingerprint.gif') }}" class="img-fluid"
                                    alt="user-pic">
                            </div>
                            <h4> <span class="text-orange">Sorry..!</span> No data</h4>
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

                    ],
                    pagination: {
                        limit: 10
                    },
                    sort: true,
                    search: true,
                }).render(document.getElementById("view_employees-table"));
            }
        });
        $(document).ready(function() {
            if (document.getElementById("newBudget_table")) {
                const grid = new gridjs.Grid({
                    columns: [{
                            id: 'department',
                            name: 'Department',

                        },
                        {
                            id: 'job_role',
                            name: 'Job Role',
                        },
                        {
                            id: 'compensation',
                            name: 'Experience(yrs)',
                        },
                        {
                            id: 'noOfOpenings',
                            name: 'No Of Openings',
                        },
                        {
                            id: 'action',
                            name: 'Action',
                        },

                    ],
                    data: [

                    ],
                    pagination: {
                        limit: 10
                    },
                    sort: true,
                    search: true,
                }).render(document.getElementById("newBudget_table"));
            }
        });
    </script>
@endsection
