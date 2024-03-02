@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="vendor-wrapper mt-30 card">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
                <h6 class="">Vendor List</h6>
                <div class=" text-end mb-2">
                    <button class="btn btn-orange me-2" data-bs-toggle="modal" data-bs-target="#newVendor">New
                        Vendor</button>
                    <button class="btn btn-orange " data-bs-toggle="modal" data-bs-target="#importVendor">
                        Import Vendor
                    </button>
                </div>
            </div>
            <div class="modal fade " id="newVendor" tabindex="-1" aria-labelledby="newVendor" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable  modal-lg ">
                    <div class="modal-content  top-line">
                        <div class="modal-header  border-0  py-2">
                            <h6 class="modal-title" id="exampleModalLabel">Add New Vendor</h6>
                            <button type="button" class=" modal-close outline-none rounded-circle border-0"
                                data-bs-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                    <div class="mb-2 floating-label">
                                        <label for="" class="  float-label">Supplier id<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control textbox " id=""
                                            placeholder="Product ID">

                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                    <div class="mb-2 floating-label">
                                        <label for="" class="  float-label">Name</label>
                                        <input type="text" class="form-control textbox" id=""
                                            placeholder="Product Name">

                                    </div>
                                </div>



                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                    <div class="mb-2 floating-label">
                                        <label for="" class="  float-label">Inward Quantity<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control textbox" id="lead-name"
                                            placeholder="Inward Quantity">

                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="mb-2 floating-label">
                                        <label for="" class="  float-label">Contact</label>
                                        <input type="text" class="form-control textbox" id="position"
                                            placeholder="Outward Quantity">

                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="mb-2 floating-label">
                                        <label for="" class="  float-label">Email</label>
                                        <input type="text" class="form-control textbox" id="lead-email"
                                            placeholder="Stock in Quantity">

                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="mb-2 floating-label">

                                        <label for="" class="  float-label">Company name</label>
                                        <input type="text" class="form-control textbox" id=""
                                            placeholder="Rate">

                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="mb-2 floating-label">

                                        <label for="" class="  float-label">Vendor category</label>
                                        <input type="text" class="form-control textbox" id=""
                                            placeholder="Rate">

                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="mb-2 floating-label">

                                        <label for="" class="  float-label">Status</label>
                                        <input type="text" class="form-control textbox" id=""
                                            placeholder="Rate">

                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="modal-footer border-0 py-2">
                            <button type="button" class="btn btn-border-primary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="vendor-table-wrapper">
                <div id="vendor-table" class="noCustomize_gridjs"></div>
            </div>
            <!-- modal for import  -->
            <div class="modal fade" id="importVendor" tabindex="-1" aria-labelledby="newLead" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-lg modal-md">
                    <div class="modal-content border-0">
                        <div class="modal-header top-line">
                            <h6 class="modal-title mb-0 " id="">Import New Vendor</h6>
                            <button type="button" class=" modal-close outline-none rounded-circle border-0"
                                data-bs-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="import-contents px-2">

                                <div class="text-end my-3">
                                    <button class="btn btn-orange "><i class="fa fa-download mx-2"></i>Download
                                        Sample</button>
                                </div>
                                <!-- <hr class=""> -->

                                <div class="instructions ">
                                    <ul class="my-2  list-style-numbered list-style-circle">
                                        <li class="list-item"> Your CSV data should be in the format below. The first line
                                            of
                                            your CSV file
                                            should
                                            be
                                            the column headers as in the table example. Also make sure that your file is
                                            UTF-8
                                            to avoid
                                            unnecessary
                                            encoding problems.</li>
                                        <li class="list-item">If the column you are trying to import is date make sure that
                                            is
                                            formatted in
                                            format
                                            Y-m-d (2022-08-13).</li>
                                        <li class="list-item"> Based on your leads <span class="text-danger"> unique
                                                validation</span>
                                            configured
                                            <a href="" class="text-info">options</a> , the lead won't be
                                            imported
                                            if:
                                        </li>

                                    </ul>
                                </div>
                                <p class="text-end text-muted">- Lead email already exists</p>
                                <p class="text-start mb-1 text-muted">If you still want to yimport all leads, uncheck all
                                    unique
                                    validation field</p>

                                <!-- import lead table -->

                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Supplier ID</th>
                                                <th>Name</th>
                                                <th>Contact</th>
                                                <th>Email</th>
                                                <th>Company Name</th>
                                                <th>Vendor Category</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td colspan="10" class="">

                                                </td>

                                            </tr>

                                        </tbody>
                                    </table>


                                </div>




                                <div class="d-flex justify-content-between align-items-center my-2">
                                    <div class="d-flex align-items-center ">
                                        <input type="file" name="upload_file" id="upload_file" accept=".xls,.xlsx"
                                            class="form-control w-50 me-2" required>

                                        <button class="btn btn-orange "><i class="fa fa-upload mx-2"></i>Upload</button>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-orange" data-bs-dismiss="modal">
                                            Import
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-border-primary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save</button>




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

            if (document.getElementById("vendor-table")) {
                const grid = new gridjs.Grid({
                    columns: [{
                            id: 'number',
                            name: 'Supplier Id',

                        },
                        {
                            id: 'name ',
                            name: ' Name',

                        },
                        {
                            id: 'job_title',
                            name: 'Contact',
                        },
                        {
                            id: 'reporting_to',
                            name: ' Email',
                        },
                        {
                            id: 'reporting_to',
                            name: ' Company Name',
                        },
                        {
                            id: 'reporting_to',
                            name: 'Vendor Category',
                        },
                        {
                            id: 'reporting_to',
                            name: 'Status ',
                        }, {
                            id: '',
                            name: 'Action ',
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
