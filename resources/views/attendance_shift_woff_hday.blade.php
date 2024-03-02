@extends('layouts.master')
@section('title')
    @lang('translation.dashboards')
@endsection
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/attendance.css') }}">
@endsection
@section('content')
    <div class="cotainer-fluid mt-30">
        <div class="card mb-2 left-line">
            <div class="pt-1 pb-0 card-body">
                <ul class="nav nav-pills nav-tabs-dashed">
                    <li class="nav-item text-muted">
                        <a class="nav-link active" data-bs-toggle="tab" href="#shiftAnd_weeklyOff">Shift & Weekly
                            Offs</a>
                    </li>
                    <li class="nav-item mx-5 text-muted">
                        <a class="nav-link" data-bs-toggle="tab" href="#shift_allowance">Shift Allowance</a>
                    </li>
                    <li class="nav-item text-muted">
                        <a class="nav-link" data-bs-toggle="tab" href="#assignment">Assignments</a>
                    </li>
                    <li class="nav-item mx-5     text-muted">
                        <a class="nav-link" data-bs-toggle="tab" href="#scheduler">Scheduler</a>
                    </li>
                    <li class="nav-item text-muted">
                        <a class="nav-link" data-bs-toggle="tab" href="#holidays">Holidays</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane show fade active" id="leave_balance" role="tabpanel"
                        aria-labelledby="pills-profile-tab">
                        <ul class="nav nav-pills  nav-tabs-dashed">
                            <li class="nav-item  text-muted">
                                <a class="nav-link active" data-bs-toggle="tab" href="#attendance_shift">Shift </a>
                            </li>

                            <li class="nav-item  mx-4 text-muted">
                                <a class="nav-link " data-bs-toggle="tab" href="#attendance_weekly-off">Weekly Off's </a>
                            </li>
                            <li class="nav-item text-muted">
                                <a class="nav-link " data-bs-toggle="tab" href="#attedance_shift-weekly-off">Shifts And
                                    Weekly Off
                                    Rules </a>
                            </li>


                        </ul>


                        <div class="row mb-3">
                            <div class="col-6"></div>

                            <div class="col-6 d-flex justify-content-end">
                                <select name="" id=""
                                    class="form-select border-orange me-2 w-50 disabled_focus">
                                    <option value="" selected hidden disabled>Department</option>
                                </select>
                                <button type="button" class="btn btn-orange" data-bs-toggle="modal"
                                    data-bs-target="#addNew_shift">
                                    <i class="fa fa-plus-circle"></i>
                                    Add Shifts
                                </button>
                            </div>

                        </div>


                        <div class="card">
                            <div class="card-body">
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane show fade active" id="attendance_shift" role="tabpanel"
                                        aria-labelledby="pills-profile-tab">

                                        <div class="row">
                                            <div class="col-12 ">
                                                <h6>General Shift <span
                                                        class="text-muted f-11 me-2">Shif-Code:GS</span><button
                                                        type="button"
                                                        class="fa outline-none border-0 bg-transparent fa-pencil text-orange"
                                                        aria-hidden="true"></button> </h6>
                                            </div>
                                            <div class="col-12">
                                                <ul class="nav nav-pills mb-3 nav-tabs-dashed">
                                                    <li class="nav-item  text-muted">
                                                        <a class="nav-link active" data-bs-toggle="tab"
                                                            href="#summary_table">Summary </a>
                                                    </li>

                                                    <li class="nav-item  mx-4 text-muted">
                                                        <a class="nav-link " data-bs-toggle="tab"
                                                            href="#employees_table">Employees</a>
                                                    </li>

                                                    <li class="nav-item  mx-4 text-muted">
                                                        <a class="nav-link " data-bs-toggle="tab"
                                                            href="#track_shift_versions">Track Shift Versions</a>
                                                    </li>

                                                </ul>

                                                <div class="tab-content" id="pills-tabContent">
                                                    <div class="tab-pane show fade active" id="summary_table"
                                                        role="tabpanel" aria-labelledby="">

                                                        <div class="track_summary_table" id="track_summary_table"></div>

                                                        <div class="row pb-4 mb-3 border-bottom ">
                                                            <div class="col-4 d-flex align-items-center ">
                                                                <p class="text-primary text-end f-14">Half day minimum
                                                                    working hours required</p>
                                                            </div>
                                                            <div class="col-2 d-flex align-items-center">
                                                                <input type="text"
                                                                    class="text-center me-2   text-muted p-0 w-25 form-control"
                                                                    name="" id="" value="4"
                                                                    disabled>
                                                                <span class="text-muted f-12">hours</span>
                                                            </div>
                                                            <div class="col-4 d-flex align-items-center ">
                                                                <p class="text-primary text-end f-14">Full day minimum
                                                                    working hours required</p>
                                                            </div>
                                                            <div class="col-2 d-flex align-items-center">
                                                                <input type="text"
                                                                    class=" text-center me-2   text-muted p-0 w-25 form-control"
                                                                    name="" id="" value="4"
                                                                    disabled>
                                                                <span class="text-muted f-12">hours</span>
                                                            </div>
                                                        </div>
                                                        <div class="row pb-2 border-bottom ">
                                                            <div class="col-2 d-flex align-items-center ">
                                                                <p class="text-primary  f-14">Grace time</p>
                                                            </div>
                                                            <div class="col-2 d-flex align-items-center">
                                                                <input type="text"
                                                                    class="text-center me-2   text-muted p-0 w-25 form-control"
                                                                    name="" id="" value="30"
                                                                    disabled>
                                                                <span class="text-muted f-12">minutes</span>
                                                            </div>
                                                            <div class="col-8  d-flex align-items-center">
                                                                <div
                                                                    class="d-flex align-items-center me-3 alert py-0 f-11 mb-0 alert-danger">

                                                                    <p> Lorem
                                                                        ipsum dolor sit amet consectetur adipisicing
                                                                        elit. Ab, natus.</p>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane show fade " id="employees_table" role="tabpanel"
                                                        aria-labelledby="">
                                                        <div class="attedance_employee" id="attedance_employee"></div>
                                                    </div>
                                                    <div class="tab-pane show fade" id="track_shift_versions"
                                                        role="tabpanel" aria-labelledby="">
                                                        <div class="shift_versionsTable" id="shift_versionsTable"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane show fade " id="attendance_weekly-off" role="tabpanel">

                                        <div class="weeklyOff_table" id="weeklyOff_table"></div>
                                    </div>
                                    <div class="tab-pane show fade " id="leave_balance" role="tabpanel">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="addNew_shift" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable  modal-xl" role="document">
                <div class="modal-content top-line">
                    <div class="modal-header py-2 new-role-header border-0 d-flex align-items-center">
                        <h6 class="mb-0">
                            Add New Shift</h6>
                        <button type="button" class="close outline-none bg-transparent border-0 h3"
                            data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body pt-0">

                        <div class="row mb-3 border-bottom-secondary">
                            <div class="col-6 mb-3">
                                <label for="" class="">Shift Name</label>
                                <input type="text" placeholder="shift name" class="form-control">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="">Shift Code</label>
                                <input type="text" class="form-control" placeholder="shift code">
                            </div>

                        </div>

                        <ul class="nav nav-pills nav-tabs-dashed mb-3">
                            <li class="nav-item text-muted">
                                <a class="nav-link active" data-bs-toggle="tab" href="#set_shift">Set shift time
                                    range</a>
                            </li>
                            <li class="nav-item mx-3 text-muted">
                                <a class="nav-link" data-bs-toggle="tab" href="#set_break">Set break time range</a>
                            </li>
                            <li class="nav-item text-muted">
                                <a class="nav-link" data-bs-toggle="tab" href="#working_hours">Working hours</a>
                            </li>
                            <li class="nav-item mx-3     text-muted">
                                <a class="nav-link" data-bs-toggle="tab" href="#late_early">Late & Early going</a>
                            </li>

                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane show fade active" id="set_shift" role="tabpanel"
                                aria-labelledby="pills-profile-tab">
                                <div class="row mb-3 ">

                                    <div class="col-6 mb-2">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="radio" name="shift_type"
                                                id="">
                                            <label class="form-check-label text-muted me-3" for="">
                                                Apply flxible gross shift
                                            </label>
                                            <input class="form-control  py-1 px-2 me-3" type="text" name="shift_type"
                                                id="" style="width: 35px">
                                            <span class="text-ash">hours</span>

                                        </div>

                                    </div>
                                    <div class="col-6 mb-2">
                                        <div class="d-flex align-items-center">
                                            {{-- <input class="form-check-input me-2" type="radio" name="shift_type"
                                                id=""> --}}
                                            <label class="form-check-label text-muted me-3" for="">
                                                Grace time
                                            </label>
                                            <input class="form-control  py-1 px-2 me-3" type="text" name="shift_type"
                                                id="" style="width: 35px">
                                            <span class="text-ash">mins</span>

                                        </div>

                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <input class="form-check-input me-2" type="radio" name="shift_type"
                                                id="">
                                            <label class="form-check-label text-muted me-3" for="">
                                                Apply standard general shift
                                            </label>

                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="start_shift me-4 d-flex align-items-center">
                                                <label class="form-check-label text-muted me-3" for="">
                                                    Shift start time
                                                </label>
                                                <input class="form-control py-1 px-2 me-3 shift_time" type="time"
                                                    name="shift_type" id="" style="width: 120px">

                                            </div>
                                            <div class="end_shift d-flex align-items-center">
                                                <label class="form-check-label text-muted me-3" for="">
                                                    Shift end time
                                                </label>
                                                <input class="form-control me-2  py-1 px-2 me-3 shift_time" type="time"
                                                    name="shift_type" id="" style="width: 120px">



                                            </div>

                                        </div>
                                        <div class=" d-flex align-items-center mb-3 ">
                                            <label class="form-check-label text-muted me-3" for="">
                                                weekoff
                                            </label>
                                            <select class="form-select" name="" style="width:200px">

                                                <option value="">Sunday</option>
                                                <option value="">Monday</option>
                                                <option value="">Tuesday</option>
                                            </select>


                                        </div>
                                        <div class=" d-flex align-items-center">

                                            <input class="form-check-input me-2" type="radio" name="shift_type"
                                                id="">
                                            <label class="form-check-label text-muted me-3" for="">
                                                Apply to all days except weekoff
                                            </label>
                                        </div>


                                    </div>


                                </div>

                            </div>
                            <div class="tab-pane  fade " id="set_break" role="tabpanel"
                                aria-labelledby="pills-profile-tab">
                                <div class="row mb-3 ">

                                    <div class="col-12 mb-2">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="radio" name="shift_type"
                                                id="">
                                            <label class="form-check-label text-muted me-3" for="">
                                                Apply flxible gross break
                                            </label>
                                            <input class="form-control  py-1 px-2 me-3" type="text" name="shift_type"
                                                id="" style="width: 35px">
                                            <span class="text-ash">mins</span>

                                        </div>

                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-check form-switch p-0 d-flex align-items-center">
                                            <input class="form-check-input toggle_sm ms-0 me-2" type="checkbox"
                                                id="flexSwitchCheckChecked">
                                            <label class="form-check-label text-muted" for="flexSwitchCheckChecked"> Do
                                                you want to split
                                                the break down</label>
                                        </div>

                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex align-items-center me-3">
                                                <label class="form-check-label text-muted me-3" for="">
                                                    Morning break
                                                </label>
                                                <input class="form-control  py-1 px-2 me-3" type="number"
                                                    placeholder="minutes" name="shift_type" id=""
                                                    style="width: 70px">
                                                <span class="text-ash">mins</span>
                                            </div>
                                            <div class="d-flex align-items-center me-3">
                                                <label class="form-check-label text-muted me-3" for="">
                                                    Lunch break
                                                </label>
                                                <input class="form-control  py-1 px-2 me-3" type="number"
                                                    placeholder="minutes" name="shift_type" id=""
                                                    style="width: 70px">
                                                <span class="text-ash">mins</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <label class="form-check-label text-muted me-3" for="">
                                                    Evening break
                                                </label>
                                                <input class="form-control  py-1 px-2 me-3" type="number"
                                                    placeholder="minutes" name="shift_type" id=""
                                                    style="width: 70px">
                                                <span class="text-ash">mins</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" d-flex align-items-center">

                                        <input class="form-check-input me-2" type="radio" name="shift_type"
                                            id="">
                                        <label class="form-check-label text-muted me-3" for="">
                                            Apply to all days except weekoff
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane  fade " id="working_hours" role="tabpanel"
                                aria-labelledby="pills-profile-tab">
                                <div class="row mb-3 ">

                                    <div class="col-6 mb-2">
                                        <div class="d-flex align-items-center">

                                            <label class="form-check-label text-muted me-3" for="">
                                                Half day minimum working hours required
                                            </label>
                                            <input class="form-control  py-1 px-2 me-3" type="text" name="shift_type"
                                                id="" style="width: 35px">
                                            <span class="text-ash">hrs</span>

                                        </div>

                                    </div>
                                    <div class="col-6 mb-2">
                                        <div class="d-flex align-items-center">

                                            <label class="form-check-label text-muted me-3" for="">
                                                Full day minimum working hours required
                                            </label>
                                            <input class="form-control  py-1 px-2 me-3" type="text" name="shift_type"
                                                id="" style="width: 35px">
                                            <span class="text-ash">hrs</span>

                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane  fade " id="late_early" role="tabpanel"
                                aria-labelledby="pills-profile-tab">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="form-check form-switch p-0 d-flex align-items-center">
                                            <input class="form-check-input toggle_sm ms-0 me-2" type="checkbox"
                                                id="flexSwitchCheckChecked">
                                            <p class="form-check-label f-15 text-primary fw-bold"
                                                for="flexSwitchCheckChecked"> Late
                                                coming and early going treatment separately?
                                            </p>
                                        </div>

                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <span class="form-check-label f-13 me-2 text-primary fw-bold">
                                                    Late LOP
                                                </span>
                                            </div>
                                            <div class="col-2">
                                                <div class="d-flex align-items-center">
                                                    <input class="form-control  py-1 px-2 me-3" type="number"
                                                        placeholder="minutes" name="shift_type" id=""
                                                        style="width: 70px">

                                                    <span class="text-ash">times</span>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="d-flex align-items-center   alert py-0 f-11 mb-0 alert-danger">

                                                    Once exceed the late LOP limit

                                                    <input class="form-control  py-1 px-2 mx-3" type="number"
                                                        placeholder="minutes" name="shift_type" id=""
                                                        style="width: 70px">
                                                    <span class="text-ash">days LOP apply</span>

                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row">
                                            <div class="col-2">
                                                <span class="form-check-label f-13 me-2 text-primary fw-bold">
                                                    Early going LOP
                                                </span>
                                            </div>
                                            <div class="col-2">
                                                <div class="d-flex align-items-center">
                                                    <input class="form-control  py-1 px-2 me-3" type="number"
                                                        placeholder="minutes" name="shift_type" id=""
                                                        style="width: 70px">

                                                    <span class="text-ash">times</span>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="d-flex align-items-center alert py-0 f-11 mb-0 alert-danger">

                                                    Once exceed the late LOP limit

                                                    <input class="form-control  py-1 px-2 mx-3" type="number"
                                                        placeholder="minutes" name="shift_type" id=""
                                                        style="width: 70px">
                                                    <span class="text-ash">days LOP apply</span>
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
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            if (document.getElementById("track_summary_table")) {
                const grid = new gridjs.Grid({
                    columns: [{
                            id: 'shift',
                            name: 'Timing',

                        },
                        {
                            id: 'monday',
                            name: 'Monday',
                        },
                        {
                            id: 'tuesday',
                            name: 'Tuesday',
                        },
                        {
                            id: 'wednesday',
                            name: 'Wednesday',
                        },
                        {
                            id: 'thursday',
                            name: 'Thursday',
                        },
                        {
                            id: 'friday',
                            name: 'Friday',
                        },
                        {
                            id: 'saturday',
                            name: 'Saturday',
                        },
                        {
                            id: 'sunday',
                            name: 'Sunday',
                        }


                    ],
                    data: [

                    ],
                    pagination: {
                        limit: 10
                    },
                    sort: true,
                    search: true,
                }).render(document.getElementById("track_summary_table"));
            }







            if (document.getElementById("attedance_employee")) {
                const grid = new gridjs.Grid({
                    columns: [{
                            id: 'shift',
                            name: 'Employee',

                        },
                        {
                            id: '',
                            name: 'Employee Number',
                        },
                        {
                            id: 'tuesday',
                            name: 'Job Title',
                        },
                        {
                            id: '',
                            name: 'Reporting To',
                        },
                        {
                            id: 'tuesday',
                            name: 'Department',
                        },
                        {
                            id: 'tuesday',
                            name: 'Location',
                        },



                    ],
                    data: [

                    ],
                    pagination: {
                        limit: 10
                    },
                    sort: true,
                    search: true,
                }).render(document.getElementById("attedance_employee"));
            }


            if (document.getElementById("shift_versionsTable")) {
                const grid = new gridjs.Grid({
                    columns: [{
                            id: 'shift',
                            name: 'Current Date',

                        },
                        {
                            id: '',
                            name: 'Updated Date',
                        },
                        {
                            id: 'tuesday',
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
                }).render(document.getElementById("shift_versionsTable"));
            }



            if (document.getElementById("weeklyOff_table")) {
                const grid = new gridjs.Grid({
                    columns: [{
                            id: 'shift',
                            name: 'Week Offs',

                        },
                        {
                            id: '',
                            name: 'Day Offs',
                        },





                    ],
                    data: [

                    ],
                    pagination: {
                        limit: 10
                    },
                    sort: true,
                    search: true,
                }).render(document.getElementById("weeklyOff_table"));
            }
        });




        $(document).ready(function() {
            if (document.getElementById("weekly_shift-table")) {
                const grid = new gridjs.Grid({
                    columns: [{
                            id: 'weekoffs',
                            name: 'Week Offs',

                        },
                        {
                            id: 'dayoffs',
                            name: 'Day Offs',
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
                }).render(document.getElementById("weekly_shift-table"));
            }
        });
    </script>
@endsection
