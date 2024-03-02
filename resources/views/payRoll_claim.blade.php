@extends('layouts.master')
@section('title')
    @lang('translation.dashboards')
@endsection
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/attendance.css') }}">
@endsection
@section('content')
    <div class="cotainer-fluid">
        <div class="card mb-2">
            <div class="py-1 card-body">
                <div class="col-8 d-flex align-items-center">
                    <ul class="nav nav-pills nav-tabs-dashed">
                        <li class="nav-item text-muted">
                            <a class="nav-link active" data-bs-toggle="tab" href="#pending">Pending</a>
                        </li>
                        <li class="nav-item text-muted">
                            <a class="nav-link" data-bs-toggle="tab" href="#approved">Approved</a>
                        </li>
                        <li class="nav-item text-muted">
                            <a class="nav-link" data-bs-toggle="tab" href="#rejected">Rejected</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <div id="pending" class="tab-pane fade show active">
                <div class="card top-line">
                    <div class="card-body">
                        <h6 class="text-left fw-bold mb-3">Claims Awaiting Approval</h6>
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
                                <button class="btn selection-btn">Pay group</button>
                                <button class="btn selection-btn">Component</button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div id="claim_pendig"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="approved" class="tab-pane fade show">
                <div class="card top-line">
                    <div class="card-body">
                        {{-- <h6 class="text-left fw-bold mb-3">Claims Approved</h6>
                        <div class="col-md-12 d-flex justify-content-between mb-3">
                            <div class="d-flex space-around-between">
                                <button class="filter-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                                        <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z"></path>
                                    </svg>
                                </button>
                                <button class="btn selection-btn">Component</button>
                                <button class="btn selection-btn">FY 2022 - 23</button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="" id="claim_approved"></div>
                        </div> --}}
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
            <div id="rejected" class="tab-pane fade">
                <div class="card top-line">
                    <div class="card-body">
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
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/gridjs/gridjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/dashboard-projects.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            if (document.getElementById("claim_pendig")) {
                const grid = new gridjs.Grid({
                    columns: [{
                            id: 'employee',
                            name: 'Employee',
                        },
                        {
                            id: 'componentname',
                            name: 'Component Name',
                        },
                        {
                            id: 'componenttype',
                            name: 'Component Type',
                        },
                        {
                            id: 'claimamount',
                            name: 'Claim Amount',
                        },
                        {
                            id: 'payableamount',
                            name: 'Payable Amount',
                        },
                        {
                            id: 'approvedon',
                            name: 'Approved On',
                        },
                        {
                            id: 'paymentstatus',
                            name: 'Payment Status',
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
                }).render(document.getElementById("claim_pendig"));
            }
        });
        $(document).ready(function() {
            if (document.getElementById("claim_approved")) {
                const grid = new gridjs.Grid({
                    columns: [{
                            id: 'employee',
                            name: 'Employee',
                        },
                        {
                            id: 'componentname',
                            name: 'Component Name',
                        },
                        {
                            id: 'componenttype',
                            name: 'Component Type',
                        },
                        {
                            id: 'claimamount',
                            name: 'Claim Amount',
                        },
                        {
                            id: 'payableamount',
                            name: 'Payable Amount',
                        },
                        {
                            id: 'approvedon',
                            name: 'Approved On',
                        },
                        {
                            id: 'paymentstatus',
                            name: 'Payment Status',
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
                }).render(document.getElementById("claim_approved"));
            }
        });
        $(document).ready(function() {
            if (document.getElementById("claim_approved")) {
                const grid = new gridjs.Grid({
                    columns: [{
                            id: 'employee',
                            name: 'Employee',
                        },
                        {
                            id: 'componentname',
                            name: 'Component Name',
                        },
                        {
                            id: 'componenttype',
                            name: 'Component Type',
                        },
                        {
                            id: 'claimamount',
                            name: 'Claim Amount',
                        },
                        {
                            id: 'payableamount',
                            name: 'Payable Amount',
                        },
                        {
                            id: 'approvedon',
                            name: 'Approved On',
                        },
                        {
                            id: 'paymentstatus',
                            name: 'Payment Status',
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
                }).render(document.getElementById("claim_approved"));
            }
        });
    </script>
@endsection
