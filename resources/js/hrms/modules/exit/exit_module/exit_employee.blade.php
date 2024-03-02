@extends('layouts.master')
@section('title')
    @lang('translation.dashboards')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/css/roles_permission.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="exit-wrapper mt-30">

        <div class="card  left-line mb-2">
            <div class="card-body  pb-0 pt-1">
                <div class="row">
                    <div class="col-9">
                        <ul class="nav nav-pills nav-tabs-dashed" role="tablist">
                            <li class="nav-item text-muted " role="presentation">
                                <a class="nav-link active pb-2" data-bs-toggle="tab" href="#personal-resignation"
                                    aria-selected="true" role="tab">
                                    Personal
                                </a>
                            </li>
                            <li class="nav-item text-muted mx-4" role="presentation">
                                <a class="nav-link  pb-2" data-bs-toggle="tab" href="#team-resignation" aria-selected="true"
                                    role="tab">
                                    Team
                                </a>
                            </li>
                            <li class="nav-item text-muted " role="presentation">
                                <a class="nav-link  pb-2" data-bs-toggle="tab" href="#org-resignation" aria-selected="true"
                                    role="tab">
                                    Org
                                </a>
                            </li>

                        </ul>

                    </div>
                    <div class="col-3 text-end">
                        <button class="btn btn-primary" id="apply_resignation">Apply Resignation</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="card mb-2">
            <div class="card-body py-1">
                <div class="row">
                    <div class="col-6 d-flex align-items-center">
                        <h6 class="">Resignation</h6>
                    </div>

                    <div class="col-6 text-end">

                    </div>
                </div>
            </div>
        </div> --}}
        <div class="card mb-0">
            <div class="card-body">
                <div class="tab-content " id="pills-tabContent">
                    <div class="tab-pane fade  active show " id="personal-resignation" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="no-data-img " id="noData" style="">
                            <div class="col-4 mx-auto text-center">
                                <img src="{{ URL::asset('assets/images/resignationNo-data.jpg') }}" class="h-100 w-100"
                                    alt="no-data">

                            </div>
                        </div>
                        <div class="resignation-content " id="resignation_form" style="display:none">
                            {{-- <form class="" id="resignationForm"> --}}
                            <div class="row">
                                <div class="col-sm-12 col-lg-6 col-xxl-6 col-xl-6 col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="">Date Of Resignation Initiated</label>
                                        <input type="text" class="form-control" id="" aria-describedby="">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-6 col-xxl-6 col-xl-6 col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="">Resignation Type</label>
                                        <select name="" id="" class="form-select form-control">
                                            <option value="">Better Prospect</option>
                                            <option value="">Marriage & Relocating</option>
                                            <option value="">Illness</option>
                                            <option value="">Difficult Work Environment</option>
                                            <option value="">Career Prospect</option>
                                            <option value="">Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-6 col-xxl-6 col-xl-6 col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="">Notice Period Date</label>
                                        <input type="Date" class="form-control" id="" aria-describedby="">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-6 col-xxl-6 col-xl-6 col-md-6">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <div class="">
                                                <label for="" class="me-2">Expected Last working Date</label>
                                                <button
                                                    class=" px-0 fa fa-info-circle btn outline-none border-0 bg-transparent"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Edit Your Expected Last working Date"></button>
                                            </div>
                                            <button class="btn outline-none border-0 bg-transparent fa text-info fa-pencil"
                                                id="expectedDate_reasonButton">
                                            </button>

                                        </div>
                                        <input type="Date" class="form-control" id="expected_lastDate"
                                            aria-describedby="" value="2013-01-08" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-6 col-xxl-6 col-xl-6 col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="">Payroll End Date</label>
                                        <input type="Date" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-6 col-xxl-6 col-xl-6 col-md-6">
                                    <div class="mb-3" id="reason_dialogueBox" style="display:none">
                                        <label for="" class="">Reason For Change In Last Working
                                            Date</label>
                                        <textarea name="" id="" cols="30" rows="2" class="resize-none form-control"></textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-12 col-lg-12 col-xxl-12 col-xl-12 col-md-12 text-end">
                                <button type="submit" class="btn btn-border-orange me-2">Save</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>

                            {{-- </form> --}}
                        </div>
                    </div>
                    <div class="tab-pane fade " id="team-resignation" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="resignation-table">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <h6 class="mb-2">Pending Task</h6>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Employee Name</th>
                                                <th>Employee Code</th>
                                                <th>Details</th>
                                                <th>Status</th>
                                                <th>Replace</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Praveen</td>
                                                <td>Abs1008</td>
                                                <td> <a role="button" class="dropdown-item cursor-pointer  text-info"
                                                        data-bs-toggle="modal" data-bs-target="#resignationDetailsView"><i
                                                            class="fa fa-eye me-1" aria-hidden="true"></i>
                                                        View</a></td>
                                                <td><span class="badge rounded-pill bg-warning">Pending</span></td>
                                                <td><button class="btn btn-orange me-2" data-bs-toggle="modal"
                                                        data-bs-target="#switch_task">Change</button></td>
                                                <td><button class="btn btn-secondary-red me-2">Reject</button><button
                                                        class="btn btn-success">Approve</button></td>
                                                {{-- <td>
                                                    <div class="dropdown custom-dropDown dropdown-action">
                                                        <button
                                                            class="btn bg-transparent  outline-none border-0 dropdown-toggle"
                                                            type="button" id="dropdownMenuButton"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                                            style="">
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="fa fa-eye text-info me-2"
                                                                    aria-hidden="true"></i>
                                                                View</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="fa fa-trash text-danger me-2"
                                                                    aria-hidden="true"></i>
                                                                Delete Resignation</a>
                                                        </div>
                                                    </div>
                                                </td> --}}
                                            </tr>
                                        </tbody>
                                    </table>


                                </div>
                                <div class="col-12 ">
                                    <h6 class="mb-2">Completed Task</h6>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Employee Name</th>
                                                <th>Employee Code</th>
                                                <th>Details</th>
                                                <th>Status</th>
                                                {{-- <th>Replace</th> --}}
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Praveen</td>
                                                <td>Abs1008</td>
                                                <td> <a role="button" class="dropdown-item cursor-pointer  text-info"
                                                        data-bs-toggle="modal" data-bs-target="#resignationDetailsView"><i
                                                            class="fa fa-eye me-1" aria-hidden="true"></i>
                                                        View</a></td>
                                                <td><span class="badge rounded-pill bg-success">Approved</span></td>
                                                {{-- <td><button class="btn btn-orange me-2" data-bs-toggle="modal"
                                                        data-bs-target="#switch_task">Change</button></td> --}}
                                                <td><button class="btn btn-secondary-red me-2">Reject</button><button
                                                        class="btn btn-success">Approve</button></td>

                                            </tr>
                                            <tr>
                                                <td>Praveen</td>
                                                <td>Abs1008</td>
                                                <td> <a role="button" class="dropdown-item cursor-pointer  text-info"
                                                        data-bs-toggle="modal" data-bs-target="#resignationDetailsView"><i
                                                            class="fa fa-eye me-1" aria-hidden="true"></i>
                                                        View</a></td>
                                                <td><span class="badge rounded-pill bg-danger">Rejected</span></td>
                                                {{-- <td><button class="btn btn-orange me-2" data-bs-toggle="modal"
                                                        data-bs-target="#switch_task">Change</button></td> --}}
                                                <td><button class="btn btn-secondary-red me-2">Reject</button><button
                                                        class="btn btn-success">Approve</button></td>

                                            </tr>
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade " id="org-resignation" role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        <div class="resignation-table">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <h6 class="mb-2">Pending Task</h6>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Employee Name</th>
                                                <th>Employee Code</th>
                                                <th>Designation</th>
                                                <th>Details</th>
                                                <th>Status</th>
                                                <th>Reporting To</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Praveen</td>
                                                <td>Abs1008</td>
                                                <td>Lead </td>
                                                <td> <a role="button" class="dropdown-item cursor-pointer  text-info"
                                                        data-bs-toggle="modal" data-bs-target="#resignationDetailsView"><i
                                                            class="fa fa-eye me-1" aria-hidden="true"></i>
                                                        View</a></td>
                                                <td><span class="badge rounded-pill bg-warning">Pending</span></td>

                                                <td>Karthi</td>

                                            </tr>
                                        </tbody>
                                    </table>


                                </div>
                                <div class="col-12 mb-2">
                                    <h6 class="mb-2">Completed Task</h6>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Employee Name</th>
                                                <th>Employee Code</th>
                                                <th>Designation</th>
                                                <th>Details</th>
                                                <th>Status</th>
                                                <th>Reporting To</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Praveen</td>
                                                <td>Abs1008</td>
                                                <td>Lead </td>
                                                <td> <a role="button" class="dropdown-item cursor-pointer  text-info"
                                                        data-bs-toggle="modal" data-bs-target="#resignationDetailsView"><i
                                                            class="fa fa-eye me-1" aria-hidden="true"></i>
                                                        View</a></td>
                                                <td><span class="badge rounded-pill bg-warning">Pending</span></td>

                                                <td>Karthi</td>

                                            </tr>
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div id="switch_task" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable  modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header py-2 new-role-header border-0 d-flex align-items-center">
                        <h6 class="modal-title">
                            Switch Task Here</h6>
                        <button type="button" class="close outline-none bg-transparent border-0 h3"
                            data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>

                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-12 col-xxl-12 col-xl-12 col-md-12">
                                <div class="mb-3">
                                    <label for="" class="">Choose The Department Here</label>
                                    <select name="" id="" class="form-select form-control">
                                        <option value="">IT</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-12 col-xxl-12 col-xl-12 col-md-12">
                                <div class="mb-3">
                                    <label for="" class="">Ask Task To</label>
                                    <select name="" id="" class="form-select form-control">
                                        <option value="">IT</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-12 col-xxl-12 col-xl-12 col-md-12 text-end">
                                <button class="btn btn-orange me-2" data-bs-toggle="modal"
                                    data-bs-target="#switch_task">Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="resignationDetailsView" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable  modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header py-2 new-role-header border-0 d-flex align-items-center">
                        <h6 class="modal-title">
                            Employee Information</h6>
                        <button type="button" class="close outline-none bg-transparent border-0 h3"
                            data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>

                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-sm-12 col-lg-12 col-xxl-12 col-xl-12 col-md-12">
                                <ul class="personal-info">
                                    <li class="border-bottom-liteAsh pb-1">
                                        <div class="title">Name</div>
                                        <div class="text">
                                            -
                                        </div>
                                    </li>
                                    <li class="border-bottom-liteAsh pb-1">
                                        <div class="title">Employee Code</div>
                                        <div class="text">
                                            -
                                        </div>
                                    </li>
                                    <li class="border-bottom-liteAsh pb-1">
                                        <div class="title">Employee Email Id</div>
                                        <div class="text">
                                            -
                                        </div>
                                    </li>
                                    <li class="border-bottom-liteAsh pb-1">
                                        <div class="title">Date Of Joining(DOJ)</div>
                                        <div class="text">
                                            -
                                        </div>
                                    </li>
                                    <li class="border-bottom-liteAsh pb-1">
                                        <div class="title">Designation</div>
                                        <div class="text">
                                            -
                                        </div>
                                    </li>
                                    <li class="border-bottom-liteAsh pb-1">
                                        <div class="title">Reporting Manager</div>
                                        <div class="text">
                                            -
                                        </div>
                                    </li>
                                    <li class="border-bottom-liteAsh pb-1">
                                        <div class="title">Notice Period</div>
                                        <div class="text">
                                            -
                                        </div>
                                    </li>
                                    <li class="border-bottom-liteAsh pb-1">
                                        <div class="title">Date Of Designation</div>
                                        <div class="text">
                                            -
                                        </div>
                                    </li>
                                    <li class="border-bottom-liteAsh pb-1">
                                        <div class="title">Last Working Date(Exp)</div>
                                        <div class="text">
                                            -
                                        </div>
                                    </li>
                                    <li class="border-bottom-liteAsh pb-1">
                                        <div class="title">Reason For Resignation</div>
                                        <div class="text">
                                            -
                                        </div>
                                    </li>

                                </ul>
                            </div>
                            {{-- <div class="col-sm-12 col-lg-12 col-xxl-12 col-xl-12 col-md-12 text-end">
                                <button class="btn btn-orange " data-bs-dismiss="modal"
                                    >Close</button>
                            </div> --}}
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


            $('#apply_resignation').click(function() {
                $('#noData').css('display', 'none');
                $('#resignation_form').css('display', 'revert');


            })

            $('#expectedDate_reasonButton').click(function() {
                $('#reason_dialogueBox').css('display', 'revert');
                $('#expected_lastDate').removeAttr('disabled');

            })





            if (document.getElementById("userRole-table")) {
                const grid = new gridjs.Grid({
                    columns: [{
                            id: 'number',
                            name: 'User',

                        },
                        {
                            id: 'number',
                            name: 'Employee Id',

                        },
                        {
                            id: 'number',
                            name: 'Added On (dd/mm/yyyy)',

                        },
                        {
                            id: 'number',
                            name: 'Actions',

                        },



                    ],
                    data: [

                    ],

                    pagination: {
                        limit: 10
                    },
                    sort: true,
                    search: true,
                }).render(document.getElementById("userRole-table"));


            }



        });
    </script>
@endsection
