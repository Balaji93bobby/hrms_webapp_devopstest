@extends('layouts.master')
@section('title')
    @lang('translation.projects')
@endsection
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/employee-directory.css') }}">






    <style>
        table {
            box-shadow: rgba(17, 17, 26, 0.1) 0px 4px 16px, rgba(17, 17, 26, 0.05) 0px 8px 32px !important;
        }

        table th {
            color: #5265a7;
            background-color: #ccd6f7;
            padding: 15px 10px !important;
            font-size: 13px;
        }

        tbody {
            background-color: #fff;
        }

        tbody tr:hover {
            background-color: #f3f3f9;

        }

        td {
            border: solid 1px #000;
            border-style: none solid solid none;
            padding: 10px;
            /* font-weight: 600; */
            color: #878aa5;

        }

        td .btn i {
            font-size: 16px;
        }


        tr:first-child th:first-child {
            border-top-left-radius: 6px !important;
        }

        tr:first-child th:first-child {
            border-bottom-left-radius: 6px !important;
        }


        tr:last-child td:first-child {
            border-bottom-left-radius: 6px !important;
        }

        tr:first-child th:last-child {
            border-top-right-radius: 6px !important;
        }

        tr:first-child th:last-child {
            border-bottom-right-radius: 6px !important;
        }


        tr:last-child td:last-child {
            border-bottom-right-radius: 6px !important;
        }


        /* for radio button */


        .switch-field {
            display: flex;

        }

        /* .directory-right button {
        background-color: #b0bff1!important;

    } */

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


@section('content')
    {{-- @component('components.organization_breadcrumb')
        @slot('li_1')
        @endslot
    @endcomponent --}}


    <div class=" card assest-wrapper mt-30">
        <div class="card-body">
            <div class="directory-content  mt-2">
                <h6 class="">Asset Inventory</h6>
                <div class="row">

                    <div class="col-12 text-end">
                        <a  data-bs-toggle="modal" role="button" data-bs-target="#modal_add_asset"
                            class="btn btn-orange  py-1 onboard-employee-btn">

                            Add New Asset
                        </a>
                        <a role="button" href="{{ route('vmt-assetinventory-bulk-upload') }}" role="button" class="btn btn-orange">Bulk
                            Import Assets</a>


                    </div>
                </div>
            </div>

            <div class="table-responsive">

                <div id="table-assets"></div>

                <!-- end table -->
            </div>




            <div id="modal_add_asset" class="modal custom-modal fade" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
                    <div class="modal-content profile-box  card-top-border">
                        <div class="modal-header py-2 border-0">
                            <h6 class="modal-title mb-1 text-primary" style="">Add New Asset
                            </h6>
                            <button type="button" class="close  border-0 h3" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="requires-validation" id="form_add_asset" novalidate>
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Asset Name</label>
                                            <input type="text" name="asset_name" class="form-control" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Asset Type</label>
                                            <input class="form-control" name="asset_type" type="text" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Serial Number</label>
                                            <input class="form-control" type="text" name="serial_number" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Warranty</label>
                                            <input class="form-control" type="text" name="warranty" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Vendor</label>
                                            <input class="form-control" type="text" name="vendor" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Assignee</label>
                                            <input class="form-control" type="text" name="assignee" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Asset Status</label>
                                            <input class="form-control" type="text" name="asset_status" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Assigned Date</label>
                                            <input class="form-control" type="date" name="assigned_date" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid date.
                                            </div>

                                        </div>
                                    </div>



                                </div>
                                <div class="submit-section">
                                    <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div id="modal_edit_asset" class="modal custom-modal fade" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content profile-box">
                        <div class="modal-header py-3 new-role-header d-flex align-items-center">
                            <h6 class="modal-title mb-1 text-primary" style="">Edit Asset
                            </h6>
                            <button type="button" class="close  border-0 h3" data-bs-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="requires-validation" id="form_edit_asset" novalidate>
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="row_id" id="row_id">
                                        <input type="hidden" name="id" id="id">
                                        <div class="form-group mb-3">
                                            <label>Asset Name</label>
                                            <input type="text" name="asset_name" id="asset_name" class="form-control"
                                                required>
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Asset Type</label>
                                            <input class="form-control" name="asset_type" id="asset_type" type="text"
                                                required>
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Serial Number</label>
                                            <input class="form-control" type="text" name="serial_number"
                                                id="serial_number" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Warranty</label>
                                            <input class="form-control" type="text" name="warranty" id="warranty"
                                                required>
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Vendor</label>
                                            <input class="form-control" type="text" name="vendor" id="vendor"
                                                required>
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Assignee</label>
                                            <input class="form-control" type="text" name="assignee" id="assignee"
                                                required>
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Asset Status</label>
                                            <input class="form-control" type="text" name="asset_status"
                                                id="asset_status" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid text.
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Assigned Date</label>
                                            <input class="form-control" type="date" name="assigned_date"
                                                id="assigned_date" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid date.
                                            </div>

                                        </div>
                                    </div>



                                </div>
                                <div class="submit-section">
                                    <button type="button" id="edit_form_edit_asset"
                                        class="btn btn-primary submit-btn">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div id="modal_delete_asset" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
                aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body text-center p-5">
                            <div class="mt-4">
                                <h4 class="mb-3">Confirm Asset Delete</h4>
                                {{-- <p class="text-muted mb-4"> The transfer was not successfully received by us. the email of the recipient wasn't correct.</p> --}}
                                <div class="hstack gap-2 justify-content-center">
                                    <input type="hidden" name="delete_row_id" id="delete_row_id">
                                    <input type="hidden" name="delete_id" id="delete_id">
                                    <button id="delete_modal_delete_asset" class="btn btn-danger">Yes</button>
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>
    </div>
@endsection
@section('script')


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

            $('#form_add_asset').on('submit', function(e) {
                e.preventDefault();

                if ($('#form_add_asset').is(':valid')) {

                    console.log("Add asset form is being submitted");

                    var form_add_data = new FormData(document.getElementById("form_add_asset"));
                    //console.log(form_add_data);

                    $.ajax({
                        url: "{{ route('vmt-assetinventory-add') }}",
                        type: "POST",
                        processData: false,
                        contentType: false,
                        data: form_add_data,
                        success: function(data) {
                            $('#modal_add_asset').modal('hide');
                            //console.log(data);
                            location.reload();
                        }
                    });

                }
            });


            if (document.getElementById("table-assets")) {
                const grid = new gridjs.Grid({
                    columns: [{
                            id: 'id',
                            name: 'ID',
                            hidden: true,
                        },
                        {
                            id: 'asset_name',
                            name: 'Name',
                            formatter: function formatter(cell) {
                                return gridjs.html(cell);
                            }
                        },
                        {
                            id: 'asset_type',
                            name: 'Asset Type',
                        },
                        {
                            id: 'serial_number',
                            name: 'Serial Number',
                        },
                        {
                            id: 'warranty',
                            name: 'Warranty',
                        },
                        {
                            id: 'vendor',
                            name: 'Vendor',
                        },
                        {
                            id: 'assignee',
                            name: 'Assignee',
                        },
                        {
                            id: 'status',
                            name: 'Status',
                            hidden: true,
                        },
                        {
                            id: 'assigned_date',
                            name: 'Assigned Date',
                        },
                        {
                            id: 'invoice',
                            name: 'Invoice',
                            formatter: function formatter(cell) {
                                var URL = "{{ url('/assets/') }}" + "/" + cell;
                                return gridjs.html('<a href=' + URL +
                                    ' target="_blank"><span class="text-link" style=" color: blue;"><i class="icon icon-lg text-info  ri-download-2-line text-primary fw-bold"></i></span></a>'
                                );
                            }
                        },
                        {
                            id: 'id',
                            name: 'Edit',
                            formatter: function formatter(cell) {

                                var htmlcontent =
                                    '<a  class="trigger_asset_edit" ><span class="text-link" style=" color: blue;"><i class="icon icon-lg  ri-pencil-line text-dark fw-bold"></i></span></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
                                //var html_edit="<button style='font-size:24px' onclick='hello()'>Edit</button>";
                                //var html_delete = '<a href='+url_delete+' target="_blank"><span class="text-link" style=" color: blue;"><i class="icon icon-lg  ri-delete-bin-line text-primary fw-bold"></i></span></a>';

                                return gridjs.html(htmlcontent);
                            }
                        },
                        {
                            id: 'delete',
                            name: 'Delete',
                            formatter: function formatter(cell) {


                                var htmlcontent =
                                    '<a  class="trigger_asset_delete" ><span class="text-link" style=" color: blue;"><i class="icon icon-lg text-danger ri-delete-bin-line text-primary fw-bold"></i></span></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
                                //var html_edit="<button style='font-size:24px' onclick='hello()'>Edit</button>";
                                //var html_delete = '<a href='+url_delete+' target="_blank"><span class="text-link" style=" color: blue;"><i class="icon icon-lg  ri-delete-bin-line text-primary fw-bold"></i></span></a>';

                                return gridjs.html(htmlcontent);
                            }
                        }

                    ],
                    pagination: {
                        limit: 10
                    },
                    sort: true,
                    search: true,
                    server: {
                        url: '{{ route('vmt-assetinventory-fetchall') }}',
                        then: data => data.map(
                            asset => [
                                asset.id,
                                asset.asset_name,
                                asset.asset_type,
                                asset.serial_number,
                                asset.warranty,
                                asset.vendor,
                                asset.assignee,
                                asset.asset_status,
                                asset.assigned_date,
                                asset.invoice,
                                asset.id,
                                asset.id
                            ]
                        )
                    },
                    //  ["01", "Jonathan", "jonathan@example.com", "Senior Implementation Architect", "Hauck Inc", "Holy See"],
                    //  ["02", "Harold", "harold@example.com", "Forward Creative Coordinator", "Metz Inc", "Iran"],
                    //  ["03", "Shannon", "shannon@example.com", "Legacy Functionality Associate", "Zemlak Group", "South Georgia"],
                    //  ["04", "Robert", "robert@example.com", "Product Accounts Technician", "Hoeger", "San Marino"],
                    //  ["05", "Noel", "noel@example.com", "Customer Data Director", "Howell - Rippin", "Germany"],

                }).render(document.getElementById("table-assets")); // card Table

                grid.on('cellClick', function(...args) {

                    var temp = JSON.stringify(args);
                    console.log(args);

                    //Show modal only if Edit column item selected
                    if (args[2]["name"] == "Edit") {
                        console.log(args);

                        EditAssetData(args[2]["name"], args[1]["data"], args[3]['cells']);
                    } else if (args[2]["name"] == "Delete") {
                        console.log(args);
                        DeleteAssetData(args[2]["name"], args[1]["data"]);
                    }

                });

            }

            $('#edit_form_edit_asset').click(function() {
                var form_data1 = new FormData(document.getElementById("form_edit_asset"));
                $.ajax({
                    url: "{{ url('vmt-assetinventory-edit') }}",
                    type: "POST",
                    dataType: "json",
                    data: form_data1,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        console.log(data + 'success');
                        if (data == "200") {
                            var rowId = $('#row_id').val() - 1;
                            var row = $("table tbody tr:eq(" + rowId + ")");
                            row.find("td:eq(0)").html('<b>' + $("#asset_name").val() + '</b>');
                            row.find("td:eq(1)").html($("#asset_type").val());
                            row.find("td:eq(2)").html($("#serial_number").val());
                            row.find("td:eq(3)").html($("#warranty").val());
                            row.find("td:eq(4)").html($("#vendor").val());
                            row.find("td:eq(5)").html($("#assignee").val());
                            row.find("td:eq(6)").html($("#assigned_date").val());
                            window.location.reload();
                        }
                        $('#modal_edit_asset').modal('hide');
                    },
                    error: function(data) {
                        console.log(data + 'error');
                    }
                });
            });

            function EditAssetData(column_name, row_id, data) {
                // console.log(column_name+" , "+ row_id);

                $('#id').val(data[0]['data']);
                $('#asset_name').val(data[1]['data']);
                $('#asset_type').val(data[2]['data']);
                $('#serial_number').val(data[3]['data']);
                $('#warranty').val(data[4]['data']);
                $('#vendor').val(data[5]['data']);
                $('#assignee').val(data[6]['data']);
                $('#asset_status').val(data[7]['data']);
                $('#assigned_date').val(moment(data[8]['data']).format('YYYY-MM-DD'));
                $('#row_id').val(row_id);
                $('#modal_edit_asset').modal('show');

            }

            $('#delete_modal_delete_asset').click(function() {
                $.ajax({
                    url: "{{ url('vmt-assetinventory-delete') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        'id': $('#delete_id').val(),
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        if (data == "200") {
                            var rowId = $('#delete_row_id').val() - 1;
                            console.log(rowId);
                            var row = $("table tbody tr:eq(" + rowId + ")").remove();
                            window.location.reload();
                        }
                        $('#modal_delete_asset').modal('hide');
                    },
                    error: function(data) {}
                });
            });

            function DeleteAssetData(column_name, row_id) {
                //console.log(column_name+" , "+ row_id);
                console.log(row_id);
                $('#delete_row_id').val(row_id);
                $('#delete_id').val(row_id);
                $('#modal_delete_asset').modal('show');
            }
        });
    </script>
@endsection
