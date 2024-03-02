@extends('layouts.master')
@section('title')
@lang('translation.dashboards')
@endsection
@section('content')
@component('components.attendance_breadcrumb')
@slot('li_1')@endslot
@endcomponent

    <div class="card flex-fill project-wrapper">
        <div class="row px-3 pt-2">
            <div class="col-md-6">
                <h5 class="text-left fw-bold pt-2">Leave Settings</h5>
            </div>
            <div class="col-md-6 d-flex px-3 justify-content-end">
                <div class="pt-2 text-md-start text-center me-3">
                    <button type="button" class="btn btn-custom-outline-secondary">
                        Leave Policy Explanation
                    </button>
                </div>
                <div class="pt-2 text-md-start text-center">
                    <button type="button" class="btn btn-custom-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-date me-1" viewBox="0 0 16 16">
                            <path d="M6.445 11.688V6.354h-.633A12.6 12.6 0 0 0 4.5 7.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675zm1.188-1.305c.047.64.594 1.406 1.703 1.406 1.258 0 2-1.066 2-2.871 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684zm2.953-2.317c0 .696-.559 1.18-1.184 1.18-.601 0-1.144-.383-1.144-1.2 0-.823.582-1.21 1.168-1.21.633 0 1.16.398 1.16 1.23z"/>
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                        </svg>
                        FY 2022 - 23
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-chevron-down ms-2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card profile-box flex-fill card-top-border w-100">
                <div class="card-body">
                    <div class="row px-3 mb-3">
                        <div class="col-md-6 px-0">
                            <h6 class="text-left fw-bold">Leave Balance</h6>
                        </div>
                        <div class="col-md-6 d-flex px-0 justify-content-end">
                            <div class="pt-2 text-md-start text-center me-3">
                                <button type="button" class="btn btn-custom-outline-secondary position-relative">
                                    Pending
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
                                        <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
                                    </svg>
                                    <div class="position_absolute-count">
                                        <span>2</span>
                                    </div>
                                </button>
                            </div>
                            <div class="pt-2 text-md-start text-center">
                                <button type="button" class="btn btn-orange">
                                    Apply Leave
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xl-3 col-md-3 col-lg-3">
                            <div class="card shadow small-card left-line">
                                <div class="card-body">
                                    <div class="text-center">
                                        <p class="text-muted f-15">Available</p>
                                        <h4 class="fw-bold text-primary mb-0">9<span class="text-secondary">/12</span></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xl-3 col-md-3 col-lg-3">
                            <div class="card shadow small-card left-line">
                                <div class="card-body text-center">
                                    <p class="text-muted f-15">Accrued so Far</p>
                                    <h4 class="fw-bold text-primary mb-0">20</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xl-3 col-md-3 col-lg-3">
                            <div class="card shadow small-card left-line">
                                <div class="card-body text-center">
                                    <p class="text-muted f-15">Carryover</p>
                                    <h4 class="fw-bold text-primary mb-0">10</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xl-3 col-md-3 col-lg-3">
                            <div class="card shadow small-card left-line">
                                <div class="card-body text-center">
                                    <p class="text-muted f-15">Carryover</p>
                                    <h3 class="fw-bold text-primary mb-0">25</h3>
                                    <div class="text-right">
                                        <button type="button" class="btn btn-orange">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-text" viewBox="0 0 16 16">
                                                <path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z"></path>
                                                <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-sm-12 col-xl-12 col-md-12 col-lg-12">
                            <h6 class="text-left fw-bold">Leave Availed</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xl-3 col-md-3 col-lg-3">
                            <div class="card shadow small-card left-line">
                                <div class="card-body">
                                    <div class="text-center">
                                        <p class="text-muted f-15">Available</p>
                                        <h4 class="fw-bold text-primary mb-0">9</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xl-3 col-md-3 col-lg-3">
                            <div class="card shadow small-card left-line">
                                <div class="card-body text-center">
                                    <p class="text-muted f-15">Accrued so Far</p>
                                    <h4 class="fw-bold text-primary mb-0">20</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xl-3 col-md-3 col-lg-3">
                            <div class="card shadow small-card left-line">
                                <div class="card-body text-center">
                                    <p class="text-muted f-15">Carryover</p>
                                    <h4 class="fw-bold text-primary mb-0">10</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xl-3 col-md-3 col-lg-3">
                            <div class="card shadow small-card left-line">
                                <div class="card-body text-center">
                                    <p class="text-muted f-15">Carryover</p>
                                    <h3 class="fw-bold text-primary mb-0">25</h3>
                                    <div class="text-right">
                                        <button type="button" class="btn btn-orange">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-text" viewBox="0 0 16 16">
                                                <path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z"></path>
                                                <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card profile-box flex-fill card-top-border w-100 p-3">
                <h6 class="text-left fw-bold mb-3">Leave History</h6>
                <div class="col-md-12 d-flex justify-content-between mb-3">
                    <div class="d-flex space-around-between">
                        <button class="filter-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                            <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z"></path>
                            </svg>
                        </button>
                        <button class="btn selection-btn">
                            Leave Type
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down ms-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path>
                            </svg>
                        </button>
                        <button class="btn selection-btn">
                            Status
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down ms-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- <div class="position_relative">
                        <input type="text" class="search-box-feild" placeholder="Search">
                        <div class="position-absolute-search">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
                            </svg>
                        </div>
                    </div> -->
                </div>
                <div class="col-md-12">
                    <!-- <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" style="padding-left: 25px">Leave Dates</th>
                                <th scope="col">Leave Type</th>
                                <th scope="col">Status</th>
                                <th scope="col">Requested by</th>
                                <th scope="col">Action Taken On</th>
                                <th scope="col">Leave Note</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row" style="padding-left: 25px">
                                    <h6>Sep 15, 2022</h6>
                                    <p>1 Day</p>
                                </th>
                                <th scope="row">
                                    <h6>Sick Leave</h6>
                                    <p>Requested on sep 14, 2022</p>
                                </th>
                                <th scope="row">
                                    <h6>Approved</h6>
                                    <p>by Augustin Raja</p>
                                </th>
                                <td>Geroge</td>
                                <td>Sep 14, 2022</td>
                                <td>Personal Emergency</td>
                                <td>
                                    <button type="button" class="btn btn-orange">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-text" viewBox="0 0 16 16">
                                            <path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z"></path>
                                            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"></path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                            <th scope="row" style="padding-left: 25px">
                                    <h6>Sep 15, 2022</h6>
                                    <p>1 Day</p>
                                </th>
                                <th scope="row">
                                    <h6>Sick Leave</h6>
                                    <p>Requested on sep 14, 2022</p>
                                </th>
                                <th scope="row">
                                    <h6>Approved</h6>
                                    <p>by Augustin Raja</p>
                                </th>
                                <td>Geroge</td>
                                <td>Sep 14, 2022</td>
                                <td>Personal Emergency</td>
                                <td>
                                    <button type="button" class="btn btn-orange">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-text" viewBox="0 0 16 16">
                                            <path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z"></path>
                                            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"></path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table> -->
                    <div id="vendor-table"></div>
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

        if (document.getElementById("vendor-table")) {
            const grid = new gridjs.Grid({
                columns: [{
                        id: 'number',
                        name: 'Leave Dates',

                    },
                    {
                        id: 'name',
                        name: 'Leave Type',
                    },
                    {
                        id: 'job_title',
                        name: 'Status',
                    },
                    {
                        id: 'reporting_to',
                        name: 'Requested by',
                    },
                    {
                        id: 'reporting_to',
                        name: 'Action Taken On',
                    },
                    {
                        id: 'reporting_to',
                        name: 'Leave Note',
                    },
                    {
                        id: 'reporting_to',
                        name: 'Actions',
                    },

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


            }).render(document.getElementById("vendor-table"));


        }
    });
</script>
@endsection
