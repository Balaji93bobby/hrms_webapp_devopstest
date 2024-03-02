@extends('layouts.master')
@section('title')
@lang('translation.dashboards')
@endsection
@section('css')
<link rel="stylesheet" href="{{ URL::asset('/assets/css/attendance.css') }}">
@endsection
@section('content')
@component('components.payroll_breadcrumb')
@slot('li_1')
@endslot
@endcomponent

    <div class="cotainer-fluid">
        <div class="card mb-2">
            <div class="py-1 card-body">
                <div class="row">
                    <div class="col-10 d-flex align-items-center">
                        <ul class="nav nav-pills nav-tabs-dashed">
                            <li class="nav-item text-muted">
                                <a class="nav-link active" data-bs-toggle="tab" href="#pay_loans">Loans</a>
                            </li>
                            <li class="nav-item text-muted">
                                <a class="nav-link" data-bs-toggle="tab" href="#policy-settings">Policies & Settings</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-2 text-end">
                        <select name="" id="" class="form-select border-orange disabled_focus">
                            <option value="" selected="" hidden="" disabled="">INR - Indian Rupee</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <div id="pay_loans" class="tab-pane fade show active">
                <div class="card top-line">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3 col-sm-12 col-xl-3 col-md-4 col-lg-3 d-flex">
                                <div class="card  box_shadow_0 border-rtb left-line w-100">
                                    <div class="card-body text-center">
                                        <p class="text-ash-medium mb-2 f-13">Outstanding Prinicple Balance</p>
                                        <h5 class="mb-0">-</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-sm-12 col-xl-3 col-md-4 col-lg-3 d-flex">
                                <div class="card box_shadow_0 border-rtb left-line w-100">
                                    <div class="card-body text-center">
                                        <p class="text-ash-medium mb-2 f-13">Total Ongoing EMI</p>
                                        <h5 class="mb-0">-</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-sm-12 col-xl-3 col-md-4 col-lg-3 d-flex">
                                <div class="card box_shadow_0 border-rtb  left-line w-100">
                                    <div class="card-body text-center">
                                        <p class="text-ash-medium mb-2 f-13">Ongoing Loans</p>
                                        <h5 class="mb-0">-</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-sm-12 col-xl-3 col-md-4 col-lg-3 d-flex">
                                <div class="card box_shadow_0 border-rtb  left-line w-100">
                                    <div class="card-body text-center">
                                        <p class="text-ash-medium mb-2 f-13">Total Loan Amount Issued</p>
                                        <h5 class="mb-0">-</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card top-line">
                    <div class="card-body">
                        <ul class="nav nav-pills nav-tabs-dashed card-header-tabs mb-3" role="tablist">
                            <li class="nav-item text-muted" role="presentation">
                                <button type="button" class="btn nav-link attendances-analyist-tab active" data-bs-toggle="tab" href="#mostHour_worked" aria-selected="true" role="tab">Outstanding Loans</button>
                            </li>
                            <li class="nav-item text-muted" role="presentation">
                                <button type="button" class="btn nav-link attendances-analyist-tab margin-left-mainases" data-bs-toggle="tab" href="#overtime_hours" aria-selected="false" role="tab" tabindex="-1">Cleared Loans</button>
                            </li>
                            <li class="nav-item text-muted" role="presentation">
                                <button type="button" class="btn nav-link attendances-analyist-tab margin-left-mainases" data-bs-toggle="tab" href="#leastHours_worked" aria-selected="false" role="tab" tabindex="-1">Loan Requested</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade active show" id="mostHour_worked" role="tabpanel" aria-labelledby="pills-home-tab">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="employee_count_percentage-chart">
                                            <div class="tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="employeeCount_chart" role="tabpanel">
                                                    <div class="col-md-12 d-flex justify-content-between mb-3">
                                                        <div class="d-flex space-around-between">
                                                            <button class="filter-btn">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                                                                    <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z"></path>
                                                                </svg> 
                                                            </button>
                                                            <button class="btn selection-btn">Department</button>
                                                            <button class="btn selection-btn">Location</button>
                                                            <button class="btn selection-btn">Status</button>
                                                            <select name="" id="" class="form-select border-orange disabled_focus">
                                                                <option value="" selected="" hidden="" disabled="">Add New Loan</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="" id="outstanding-loan"></div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade " id="emplyeePercentage_chart" role="tabpanel">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="tab-pane fade" id="overtime_hours" role="tabpanel" aria-labelledby="pills-profile-tab"></div>
                                <div class="tab-pane fade" id="leastHours_worked" role="tabpanel" aria-labelledby="pills-contact-tab"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        
                    </div>
                </div>
            </div>
            <div id="policy-settings" class="tab-pane fade">
                <div class="card top-line">
                    <div class="card-body">
                        <ul class="nav nav-pills nav-tabs-dashed card-header-tabs mb-3" role="tablist">
                            <li class="nav-item text-muted" role="presentation">
                                <button type="button" class="btn nav-link attendances-analyist-tab active" data-bs-toggle="tab" href="#loan-policies" aria-selected="true" role="tab">Loan Policies</button>
                            </li>
                            <li class="nav-item text-muted" role="presentation">
                                <button type="button" class="btn nav-link attendances-analyist-tab margin-left-mainases" data-bs-toggle="tab" href="#loan-categories" aria-selected="false" role="tab" tabindex="-1">Loan Categories</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade active show" id="loan-policies" role="tabpanel" aria-labelledby="pills-home-tab">
                                <h6 class="text-left fw-bold">Loans Policies Configuration</h6>
                                <ul class="ps-5">
                                    <li>
                                        <h6 class="text-left fw-bold">Get started by configuration loan eligibility criteria and intresetd rate calculation.</h6>
                                        <p class="text-ash-medium mb-2 f-13 ">Define who is eligibility criteria and interest rate calculation.</p>
                                    </li>
                                    <li>
                                        <h6 class="text-left fw-bold">Get started by configuration loan eligibility criteria and intresetd rate calculation.</h6>
                                        <p class="text-ash-medium mb-2 f-13 ">Define who is eligibility criteria and interest rate calculation.</p>
                                    </li>
                                </ul>
                                <div class="col-md-12 text-end">
                                    <button class="btn selection-btn">Add Loan Policy</button>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="loan-categories" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <div class="row">
                                    <div class="col-md">
                                        <h6 class="text-left fw-bold">Loan categories</h6>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="" id="" class="form-select border-orange disabled_focus">
                                            <option value="" selected="" hidden="" disabled="">Add New Loan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div id="loan-categories" class=""></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="rejected" class="tab-pane fade"></div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/gridjs/gridjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/dashboard-projects.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            if (document.getElementById("outstanding-loan")) {
                const grid = new gridjs.Grid({
                    columns: [{
                            id: 'month',
                            name: 'Upcoming Month',
                        },
                        {
                            id: 'estimate_employee-cost',
                            name: 'Estimate Employee Cost',
                        },
                        {
                            id: 'compensation_cost',
                            name: 'Compensation Cost',
                        },
                        {
                            id: 'fixpay',
                            name: 'Fix Pay',
                        },
                        {
                            id: 'bonus',
                            name: 'Bonus',
                        },
                        {
                            id: 'other',
                            name: 'Others',
                        },
                        {
                            id: 'finalcost',
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
                }).render(document.getElementById("outstanding-loan"));
            }
        });

        $(document).ready(function() {
            if (document.getElementById("loan-categories")) {
                const grid = new gridjs.Grid({
                    columns: [{
                            id: 'loan-categories',
                            name: 'Loan Categories',
                        },
                        {
                            id: 'policiesusing',
                            name: 'Policies Using',
                        },
                        {
                            id: 'lastupdate',
                            name: 'Last Update',
                        },
                        {
                            id: 'action',
                            name: 'Action',
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
                }).render(document.getElementById("loan-categories"));
            }
        });
    </script>
@endsection
