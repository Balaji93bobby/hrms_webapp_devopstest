{{-- @extends('layouts.master') --}}
@section('css')
    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/crm.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/gridjs/gridjs.min.css') }}">

    <style>
        .project-wrapper {
            position: relative;
            top: -20px;
        }


        /* for radio button */


        .switch-field {
            display: flex;

        }


        .switch-field input {
            position: absolute !important;
            clip: rect(0, 0, 0, 0);
            height: 1px;
            width: 1px;
            border: 0;
            overflow: hidden;
        }

        .switch-field label {
            background-color: #fff;
            color: #acb0b0;
            font-size: 14px;
            line-height: 1;
            /* font-weight:600; */
            text-align: center;
            padding: 5px 15px;
            margin-right: -1px;
            /* border: 1px  solid rgba(0, 0, 0, 0.2); */
            /* box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1); */
            transition: all 0.1s ease-in-out;
            margin-bottom: 0px !important;
        }

        .switch-field label:hover {
            cursor: pointer;
        }

        .switch-field input:checked+label {

            box-shadow: none;
            color: #002f56;
            background-color: #B8C4FF !important;
            font-weight: 600;
        }

        .switch-field label:first-of-type {
            border-radius: 4px 0 0 4px;
        }

        .switch-field label:last-of-type {
            border-radius: 0 4px 4px 0;
        }

        .search-content .directory-search-bar {
            background: #fff !important;
            padding: 4px 0px !important;

        }

        .form-control:focus {
            /* border: 2px solid #1c8b8d !important; */
            border: 1px solid #c1cef9 !important;
        }
    </style>
@endsection

{{-- @section('content') --}}
    <div class="client-wrapper card ">
        <div class="card-body">

            <div class=" text-end">
                <button class="btn btn-orange me-2" data-bs-toggle="modal" data-bs-target="#newClient"
                onclick="window.location='{{ route('vmt_clientOnboarding-route'); }}'">New
                    Client</button>
                {{-- <button class="btn btn-orange " data-bs-toggle="modal" data-bs-target="#importClient">
                    Import Client
                </button> --}}
            </div>

            <div class="client-table-wrapper">
                <div id="client-table" class="noCustomize_gridjs"></div>
            </div>


            <!-- modal for import  -->
            {{-- <div class="modal fade" id="importClient" tabindex="-1" aria-labelledby="newLead" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-lg modal-md">
                    <div class="modal-content top-line ">
                        <div class="modal-header border-0">
                            <h6 class="modal-title mb-0 " id="">Import Client</h6>
                            <button type="button" class="modal-close outline-none  border-0" data-bs-dismiss="modal"
                                aria-label="Close">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="import-contents px-2">

                                <div class="text-end ">
                                    <button class="btn btn-orange "><i class="fa fa-download mx-2"></i>Download
                                        Sample</button>
                                </div>
                                <!-- <hr class=""> -->

                                <div class="instructions ">
                                    <ul class="my-2 list-style-numbered list-style-circle">
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

                                                <th>Client ID</th>
                                                <th>Name</th>
                                                <th>Contact</th>
                                                <th>Email</th>
                                                <th>Company Name</th>
                                                <th>Contact</th>
                                                <th>Customer Type</th>
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
            </div> --}}
        </div>
    </div>
{{-- @endsection --}}
@section('script-gridjs-clients')
    <script>
        $(document).ready(function() {

            (function() {
                'use strict'
                const forms = document.querySelectorAll('.requires-validation')
                Array.from(forms)
                    .forEach(function(form) {
                        form.addEventListener('submit', function(event) {
                            if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            }

                            form.classList.add('was-validated')
                        }, false)
                    })
            })()

            if (document.getElementById("client-table")) {
                const grid = new gridjs.Grid({
                    columns: [{
                            id: 'id',
                            name: 'ID',
                            hidden: true,

                        },
                        {
                            id: 'client_code',
                            name: 'Client Code',
                            formatter: function formatter(cell) {
                                return gridjs.html(cell);
                            }
                        },
                        {
                            id: 'client_name',
                            name: 'Client Name',
                        },
                        {
                            id: 'authorised_person_contact_number',
                            name: 'Contact',
                        },
                        {
                            id: 'authorised_person_contact_email',
                            name: 'Email',
                        },
                        {
                            id: 'contract_start_date',
                            name: 'Contract Start Date',
                        },
                        {
                            id: 'contract_end_date',
                            name: 'Contract End Date',
                        },
                        {
                            id: 'subscription_type',
                            name: 'Subscription Type',
                            // hidden:true,
                        }
                    ],
                    pagination: {
                        limit: 10
                    },
                    sort: true,
                    search: true,
                    server: {
                        url: '{{ route('vmt-clients-fetchall') }}',
                        then: data => data.map(
                            client => [
                                client.id,
                                client.client_code,
                                client.client_name,
                                // client.address,
                                client.authorised_person_contact_number,
                                client.authorised_person_contact_email,
                                client.contract_start_date,
                                client.contract_end_date,
                                client.subscription_type,

                            ]
                        )
                    },
                }).render(document.getElementById("client-table")); // card Table
            }
        });
    </script>
@endsection
