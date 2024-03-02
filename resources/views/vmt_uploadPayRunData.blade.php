@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/hr_dashboard.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/employee_bulk.css') }}" rel="stylesheet">
@endsection

@section('content')
    {{-- @component('components.payroll_breadcrumb')
        @slot('li_1')
        @endslot
    @endcomponent --}}
    <div class="upload-payslip-wrapper">
        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow profile-box ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 ">
                                <div class="col-form-label">
                                    <h6 class=""> Upload Data</h6>
                                    <div class="col col-form-label">
                                        <ul class="list-style-numbered list-style-circle p-4">
                                            <form method="POST" id='role-form' action="{{ url('/vmt-payslip') }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <li>Download the
                                                    {{-- <a href="{{ url('/assets/payslip_sheet.xls') }}" target="_blank">
                                                        <span class="text-link" style=" color: blue;">Sample File</span></a> --}}
                                                        <a class="choose-file ms-1" href="{{ url('/assets/payslip_sheet.xls') }}" target="_blank">

                                                            <i class="fa fa-file" aria-hidden="true"></i>
                                                            Sample file
                                                        </a>


                                                </li>
                                                <li>Read the upload instructions on the right before uploading .</li>
                                                <li>Fill the information in excel template</li>
                                                <li class="">Upload the excel sheet

                                                        <span class="choose-file ms-1">
                                                            <input name="file" type="file">
                                                            <i class="fa fa-file" aria-hidden="true"></i>
                                                            Choose file
                                                        </span>



                                                    <div class="text-end mt-2">
                                                        <button type="submit" class=" btn btn-orange">Upload</button>
                                                    </div>
                                                    {{-- <span container="body" class="fa fa-info cursor-pointer"></span> --}}
                                                </li>

                                        </ul>

                                        <div class="row mt-4">
                                                <div class="col-xl-12">
                                                    <div id="success-msg"></div>
                                                    <div id="error-msg"></div>

                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-6 ">
                                <div class="col-form-label">
                                    <h6> Upload Instructions</h6>
                                    <div class="alert f-12 alert-warning py-2"><i class="fa fa-warning text-danger"></i>
                                        Read these instructions before uploading the file.
                                    </div>
                                    <div>
                                        <ul class="list-style-circle">
                                            <li class="pl-28"> Client Code, Client Name, Billing Currency, Project Code,
                                                Project
                                                Name, Start Date, Billing Type are required to create new projects and
                                                clients.
                                            </li>

                                            <li class="pl-28">To add new project under existing client, client name and
                                                client
                                                code given in excel should be same as client name and client code</li>

                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="card-header border-0 align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">
                </div>

                <div class="card-body  pb-2">
                    <xhr-file-upload>
                                    <div class="d-inline-flex justify-content-center align-items-center">
                                        <div containerclass="max-w-300" container="body" class="d-inline-block position-relative"><button class="btn btn-sm btn-primary">Upload Excel File</button><input type="file" name="fileupload" class="input-file" accept=".xlsx"></div>
                                        <div class="ml-8"><span containerclass="max-w-300" container="body" class="icon ic-info cursor-pointer"></span>

                            </div>
                            <xhr-file-upload>


                    <div> --}}
                    {{-- <form method="POST" id='role-form' action="{{url('/vmt-payslip')}}"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label">Select Files</label>
                    <div class="col-md-10">
                        <input name="file" type="file">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="text-end col-xl-12">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
                </form> --}}
                </div>
            </div><!-- end card body -->
        </div>
        {{-- </div>end col --}}
        {{-- </div>end row --}}
        <div style="z-index: 11">
            <div id="borderedToast2" class="toast toast-border-success overflow-hidden mt-3" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-2">
                            <i class="ri-checkbox-circle-fill align-middle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0" id="alert-msg">Yey! Everything worked!</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- ui notifications -->

    <script src="{{ URL::asset('/assets/libs/prismjs/prismjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/notifications.init.js') }}"></script>
    <!-- apexcharts -->

    <script type="text/javascript">
        $('#role-form').on('submit', function(e) {
            e.preventDefault();

            //var formData = new FormData(this);
            var roleUri = $('#role-form').attr('action');
            console.log(roleUri);

            $('#error-msg').html('');
            $('#error-msg').append('<b>Uploading now...<br/></b>');

            $.ajax({
                type: "POST",
                url: roleUri,
                enctype: 'multipart/form-data',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(ajaxData) {
                   /* $('#alert-msg').html(data);
                    var toastLiveExample3 = document.getElementById("borderedToast2");
                    var toast = new bootstrap.Toast(toastLiveExample3);
                    toast.show();*/


                        $('#error-msg').html('');
                        $('#error-msg').append('<b>Upload Status : <br/></b>');
                        $('#error-msg').append(ajaxData.message+' : <br/>');

                        //var jsonResponse = JSON.parse(data);
                        console.log('Data array length : '+ajaxData.data.length);

                        for(var i=0; i < ajaxData.data.length; i++)
                        {
                            var row_data = ajaxData.data[i];
                            $('#error-msg').append('<b class="f-15 ">'+ row_data.message+ '<b/><br/>');

                            if(ajaxData.status == 'failure'){

                                var json_error_fields = JSON.parse(row_data.error_fields);
                                var keys = Object.keys(json_error_fields);

                                for(var j=0;j<keys.length;j++)
                                {
                                        $('#error-msg').append('<ul class="list-unstyled ms-3"><li>'+'<span class="badge bg-primary f-14">' + json_error_fields[keys[j]] +'</span>' + '</li></ul>');
                                }
                            }

                            console.log(row_data.message);

                        }
                    //alert(data); // show response from the php script.
                }
            })
            //console.log($('#role-form').serialize());
        });
    </script>
@endsection
