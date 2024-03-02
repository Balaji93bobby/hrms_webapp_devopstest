@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/employee_bulk.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/hr_dashboard.css') }}" rel="stylesheet">
@endsection
@section('content')

{{-- @component('components.organization_breadcrumb')
@slot('li_1') @endslot
@endcomponent --}}

    <div class="uploadEmployee-wrpper mt-30 ">
        <div class="border-0 shadow card profile-box card-top-border">
            <div class="form-control">
                <div class="row">
                    <div class="col-md-5 col-xl-5 col-sm-12">
                        <h6 class="text-xl font-semibold"> Payroll Components Upload</h6>
                        <div class="col col-form-label">
                            <ul class="list-style-numbered ">
                                <li class="my-4"><i class="text-green-500 fa fa-step-forward" aria-hidden="true"></i> Download


                                <li class="my-4">
                                    <form method="POST" id='role-form'
                                        action="{{ url('vmt-Fin-Components/upload') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div>
                                            <!-- <span class="">Please Upload the employees details excel-sheet.</span> -->
                                            <div class="p-2 my-4 bg-gray-100 rounded-lg">
                                                  <span class="choose-file ms-1">
                                                <input name="file" type="file" required>
                                                <i class="fa fa-file" aria-hidden="true"></i>
                                                Choose file
                                            </span>
                                            <span style="width: 500px;" class="mx-4 text-bold" id="uploaded_doc"></span>
                                        </div>
                                            <!-- <span class="choose-file ms-1">
                                                <input name="file" type="file" required>
                                                <i class="fa fa-file" aria-hidden="true"></i>
                                                Choose file
                                            </span> -->
                                        </div>

                                            {{-- <div class="col-md-10">
                                                <input id="upload_doc" name="file" type="file" required>
                                            </div> --}}

                                            <span style="width: 500px;" class="font-bold" id="uploaded_doc"></span>




                                            <div class="text-end">
                                                <button type="submit" class="btn btn-orange">Upload</button>
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

    @endsection
    @section('script')
        <!-- ui notifications -->

        <script src="{{ URL::asset('/assets/libs/prismjs/prismjs.min.js') }}"></script>
        <!-- apexcharts -->

        <!-- dashboard init -->

        <script type="text/javascript">
            $('#role-form').on('submit', function(e) {
                e.preventDefault();
                //$('#error-msg').html('Please wait. Uploading....');
               $('#success-msg').html('');
                var formData = new FormData(this);
                var roleUri = $('#role-form').attr('action');
                console.log(roleUri);

                $.ajax({
                    type: "POST",
                    url: roleUri,
                    enctype: 'multipart/form-data',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(ajaxData) {
                        console.log("Got response....");
                        console.log("Status message : "+ajaxData.status);
                        console.log(ajaxData);
                        if(ajaxData.status == 'success'){
                            Swal.fire({
                            title: ajaxData.message,
                            text: ajaxData.status,
                            type: "success"
                        })
                        }


                       // $('#error-msg').html('');
                      // $('#error-msg').append('<b>Upload Status : <br/></b>');
                       // $('#error-msg').append(ajaxData.message+' : <br/>');

                       // console.log('Data array length : '+ajaxData.data.length);

                        // for(var i=0; i < ajaxData.data.length; i++)
                        // {
                        //     var row_data = ajaxData.data[i];
                        //     $('#error-msg').append('<ul><li><b>'+ row_data.message+ '<b/></li></ul>');

                        //     if(ajaxData.status == 'failure'){

                        //         var json_error_fields = JSON.parse(row_data.error_fields);
                        //         var keys = Object.keys(json_error_fields);

                        //         for(var j=0;j<keys.length;j++)
                        //         {
                        //                 $('#error-msg').append('<p>&emsp;'+ json_error_fields[keys[j]]+ '</p>');
                        //         }
                        //     }

                        //     console.log(row_data.message);

                        // }//for
                    },
                    error: function(data) {
                        //console.log('error', data);
                       // $('#error-msg').html(data.responseText);
                    }
                })
                //console.log($('#role-form').serialize());
            });


      $(document).ready(function(){
        $('input[type="file"]').change(function(e){
            var fileName = e.target.files[0].name;
            $("#uploaded_doc").html(fileName)
        });
    });
        </script>
    @endsection
