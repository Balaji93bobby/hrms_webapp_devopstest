@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/crm.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/gridjs/gridjs.min.css') }}">

    <style>
        .department-wrapper {
            position: relative;


        }

        .department-wrapper .bulk-assign {
            position: absolute;
            top: 12px;
            right: 0px;
            z-index: 5;
        }
    </style>
@endsection



@section('content')
    <div class="main container-fluid mt-30">
        <div class="card headcont  ">
            <div class="card-body">
                <div class="d-flex  justify-content-between mb-3">
                    <h6 class="text-muted">Department</h6>
                    <div class="d-flex">
                        <div class="dropdown me-2 ">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Departments
                            </button>
                            <ul class="dropdown-menu " aria-labelledby="">
                                <li>
                                    <div class="dropdown-item">
                                        <div class="search-content">

                                            <i class=" ri-search-line "></i>
                                            <input type="text" class="search-bar form-control py-1 rounded"
                                                placeholder="Search">
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <p class="text-muted dropdown-item">Humen resources</p>
                                </li>
                                <li>
                                    <p class="text-muted dropdown-item">Content creative</p>
                                </li>
                                <li>
                                    <p class="text-muted dropdown-item">Design/Art</p>
                                </li>

                            </ul>
                        </div>

                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#add_department">Add
                            Department</button>
                    </div>
                </div>


                <div class="card top-line mb-0">
                    <div class="card-body">
                        <div class="d-flex  justify-content-between">
                            <h6 class="text-muted">HR Resource <small class="text-muted">(Department)</small> </h6>
                            <div class="d-flex">
                                <button class="btn btn-orange me-2" data-bs-toggle="modal"
                                    data-bs-target="#edit_department"><i class="fa fa-pencil me-1"></i>Edit</button>
                                <button class="btn btn-orange"><i class="fa fa-trash me-1"></i>Delete</button>
                            </div>
                        </div>

                        <div class="fill salary-header nav-tab-header">
                            <div>
                                <ul class="nav nav-pills    nav-tabs-dashed" id="pills-tab" role="tablist">
                                    <li class="nav-item active ember-view me-4" role="presentation">
                                        <a class="nav-link active ember-view p-0" id="pills-home-tab" data-bs-toggle="pill"
                                            href="" data-bs-target="#department_employee" role="tab"
                                            aria-controls="pills-home" aria-selected="true">
                                            Employees</a>
                                    </li>
                                    <li class="nav-item  ember-view mx-4 " role="presentation">
                                        <a class="nav-link  ember-view p-0" id="pills-home-tab" data-bs-toggle="pill"
                                            href="" data-bs-target="#department_settings" role="tab"
                                            aria-controls="pills-home" aria-selected="true">
                                            Settings</a>
                                    </li>

                                </ul>

                            </div>

                        </div>

                        <div class="tab-content mt-3" id="pills-tabContent">

                            <div class="tab-pane  fade show active" id="department_employee" role="tabpanel"
                                aria-labelledby="pills-home-tab">

                                <div id="ember83" class="ember-view department-wrapper">
                                    <div class="bulkhead  bulk-assign   d-flex justify-content-between">
                                        <button class="btn btn-orange" data-bs-toggle="modal"
                                            data-bs-target="#bulk_department">Bulk Assign Employees</button>
                                    </div>
                                    <!-- <div class="table-responsive">

                                                    <table class=" table table-hover    ">
                                                            <thead class="tabhead text-white">

                                                                <th>Employee Number</th>
                                                                <th>Employee Name</th>
                                                                <th>Job Title</th>
                                                                <th>Reporting to</th>

                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                    </div> -->
                                    <div class="table-responsive">
                                        <div id="department-table"></div>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade mt-3 " id="department_settings" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                <div class="text-right">
                                    <button class="btn btn-orange me-2" data-bs-toggle="modal" data-bs-target="#"><i
                                            class="fa fa-pencil me-1"></i>Edit</button>
                                </div>

                                <div class="form-check ">
                                    <input class="form-check-input" type="checkbox" value="" id="post_ckb">
                                    <label class="form-check-label text-muted" for="post_ckb">
                                        Employees can post in this department
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="announcements_ckb">
                                    <label class="form-check-label text-muted" for="announcements_ckb">
                                        Employees can post announcements in this department
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="post_polls_ckb">
                                    <label class="form-check-label text-muted" for="post_polls_ckb">
                                        Employees can post polls in this department
                                    </label>
                                </div>
                                <div class="text-right">
                                    <button class="btn  btn-primary  ">Save</button>
                                </div>

                            </div>
                        </div>


                        <div class="modal fade" id="add_department" tabindex="-1" aria-labelledby=""
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered  modal-md">
                                <div class="modal-content top-line">
                                    <div class="modal-header border-0 py-2">
                                        <h6 class="modal-title" id="">Add Department</h6>
                                        <button type="button" class="modal-close outline-none  border-0"
                                            data-bs-dismiss="modal" aria-label="Close">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="form_addDepartment" enctype="multipart/form-data" class=" ">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                    <div class="mb-3 floating-label">
                                                        <label for="" class="form-label  float-label">Name</label>
                                                        <input type="text" class="form-control textbox "
                                                            id="addDep_name" name="addDep_name" placeholder="Name">

                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                    <div class="mb-3 floating-label">
                                                        <label for="" class="form-label  float-label">Department
                                                            email</label>
                                                        <input type="email" class="form-control textbox"
                                                            name="addDep_email" id="addDep_email"
                                                            placeholder="Department email">

                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                    <div class="mb-3 floating-label">
                                                        <label for=""
                                                            class="form-label  float-label">Description<span
                                                                class="text-danger">*</span></label>
                                                        <textarea class="form-control" rows="4" name="addDep_description" id="addDescription"></textarea>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="alert alert-success py-1 align-items-center mb-2" role="alert" id="add_successMsg" style="display:none;">
                                                <div class="fw-bold f-13">
                                                    <i class="fa fa-check-circle f-15 fw-bold" aria-hidden="true"></i>  Department added successfully
                                                </div>
                                            </div>
                                            <div class="alert alert-danger py-1 align-items-center mb-2" role="alert" id="add_faliureMsg" style="display:none;">
                                                <div class="fw-bold f-13">
                                                    <i class="fa fa-exclamation-circle f-15 fw-bold" aria-hidden="true"></i>  Department already exists
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <button type="button" class="btn btn-orange me-2"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button class="btn btn-orange" type="button"
                                                    id="btn_addDepartment">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="edit_department" tabindex="-1" aria-labelledby=""
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered  modal-md">
                                <div class="modal-content top-line">
                                    <div class="modal-header border-0 py-2">
                                        <h6 class="modal-title" id="">Edit Department</h6>
                                        <button type="button" class="modal-close outline-none  border-0"
                                            data-bs-dismiss="modal" aria-label="Close">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                <div class="mb-3 floating-label">
                                                    <label for="" class="form-label  float-label">Human
                                                        resource</label>
                                                    <input type="text" class="form-control textbox " id=""
                                                        name="name" placeholder="Human resource">

                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                <div class="mb-3 floating-label">
                                                    <label for="" class="form-label  float-label">Department
                                                        email</label>
                                                    <input type="email" class="form-control textbox" name="email"
                                                        id="" placeholder="Department email">

                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                <div class="mb-3 floating-label">
                                                    <label for=""
                                                        class="form-label  float-label">Description</label>
                                                    <textarea class="form-control" rows="4" name="description"></textarea>

                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer ">
                                        <button type="button" class="btn btn-orange me-2"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-orange">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="bulk_department" tabindex="-1" aria-labelledby=""
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered  modal-xl">
                                <div class="modal-content top-line">
                                    <div class="modal-header border-0 py-2">
                                        <h6 class="modal-title" id="">Bulk Assign Employee</h6>
                                        <button type="button" class="modal-close outline-none  border-0"
                                            data-bs-dismiss="modal" aria-label="Close">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-muted py-2 f-14">You can Import Employee Group Assignments in bulk
                                            using the Excel file import here. Follow the instructions below. Please ensure
                                            you read all the upload instructions before filling in the excel template.</p>
                                        <div class="row">
                                            <div class="col-md-6 col-xl-6 col-sm-12 col-xl-6 col-xxl-6">
                                                <h6 class="text-muted">Upload Data </h6>
                                                <div class="col col-form-label">
                                                    <ul class="list-style-numbered list-style-circle ">
                                                        <li>Download the Excel Template

                                                            <a class="choose-file ms-1"
                                                                href="{{ url('/assets/bulk_assign_employee.xlsx') }}"
                                                                target="_blank">
                                                                <i class="fa fa-file" aria-hidden="true"></i>Sample
                                                                File</span></a>
                                                        </li>
                                                        <li>Read the upload instructions on the right before uploading</li>
                                                        <li>Fill the information in excel template</li>
                                                        <li>
                                                            <form method="POST" id='role-form'
                                                                action="{{ url('vmt-employess/quick-onboarding/upload') }}"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <div>
                                                                    <span>Please Upload the employees details
                                                                        excel-sheet.</span>
                                                                    <span class="choose-file ms-1">
                                                                        <input name="file" type="file" required>
                                                                        <i class="fa fa-file" aria-hidden="true"></i>
                                                                        Choose file
                                                                    </span>
                                                                </div>
                                                                <div class="text-end">
                                                                    <button type="submit"
                                                                        class="btn btn-orange">Upload</button>
                                                                </div>

                                                                <div class="">

                                                                    <p id="success-msg"></p>
                                                                    <p id="error-msg"></p>


                                                                </div>
                                                            </form>
                                                        </li>
                                                    </ul>

                                                    </form>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-xl-6 col-sm-12 col-xl-6 col-xxl-6">
                                                <h6 class="text-muted"> Upload Instructions</h6>
                                                <div class="alert py-2 f-12 alert-warning"><i
                                                        class="fa fa-warning text-danger"></i> Read
                                                    these instructions before uploading the file.</div>
                                                <div>
                                                    <ul class="list-style-circle">
                                                        <li>Group types can be assigned or updated for the employee from
                                                            this import</li>
                                                        <li>Employee Number, Employee Name, Group Name all are required for
                                                            importing employee group type assignments.</li>
                                                        <li> If group details were not added earlier, then group details
                                                            will be added for the employee.</li>
                                                        <li> If group details are already present for the employee, then
                                                            group details will be updated for the employee.</li>

                                                    </ul>

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
        <script src="{{ URL::asset('assets/libs/gridjs/gridjs.min.js') }}"></script>

        <script src="{{ URL::asset('/assets/js/pages/dashboard-projects.init.js') }}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {

                if (document.getElementById("department-table")) {
                    const grid = new gridjs.Grid({
                        columns: [{
                                id: 'number',
                                name: 'Employee Number',

                            },
                            {
                                id: 'name ',
                                name: 'Employee Name',

                            },
                            {
                                id: 'job_title',
                                name: ' Job Title',
                            },
                            {
                                id: 'reporting_to',
                                name: ' Reporting to',
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




                    }).render(document.getElementById("department-table"));



                }

                $("#btn_addDepartment").click(function() {
                    var addName = $("#addDep_name").val();
                    var addemail = $("#addDep_email").val();
                    var addDes = $("#addDep_description").val();
                    console.log("Submitted");
                    $.ajax({
                        url: "{{ route('department-add') }}",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "form_data": $("#form_addDepartment").serialize(),
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                $("#add_successMsg").css({"display":"flex"});
                            } else
                            if (data.status == "failure") {
                                $("#add_faliureMsg").css({"display":"flex"});
                            }

                        }
                    });
                });



            });
        </script>
    @endsection
