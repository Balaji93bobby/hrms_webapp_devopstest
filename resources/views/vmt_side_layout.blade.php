@extends('layouts.master')
@section('css')

    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">
    <style type="text/css">

        input[type=file]{
            color:transparent;
        }

    </style>
@endsection
@section('content')


<div class="settings-layout p-0 d-flex justify-content-start container-fluid ">





    <div class="right-content p-0 mx-3 container-fluid">


        <div class="container p-0  bg-white my-3 tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="card ">
                <div class="card-body">
                    <div>
                        <h2>General Info</h2>
                        <p></p>
                    </div>
                <form method="POST" id='role-form' action="{{url('/vmt-general-info')}}" enctype="multipart/form-data" >
                    @csrf
                    <div class="mb-3">
                        <label for="short-name" class="form-label">Short Name</label>
                        <input type="text" class="form-control w-25" id="short-name" name="short_name">

                    </div>

                    <div class="mb-3 d-flex flex-column">
                        <label for="logo" class="form-label">Logo</label>


                        <span class="text-secondary">Logo dimensions cannot exceed 100 px width
                            60
                            px height. <span class="text-danger">*</span> </span>

                    </div>

                    <div class="mb-3">
                        <div class="logo-image d-flex align-items-center">
                            <img src="http://127.0.0.1:8000/assets/images/vasa.jpg" alt="brand-logo"
                                accept=".png,.jpg,.jpeg,.bmp">
                            <label for="img-pin">
                                <i class="ri-attachment-line px-1"></i>
                                <span>
                                    Upload</span>&nbsp;
                                <input type="file" id="logo" name="logo" accept=".png,.jpg,.jpeg,.bmp">
                            </label>
                        </div>

                    </div>


                    <div class="mb-3 ">
                        <div class="background-image-content d-flex flex-column">
                            <label for="logo" class="form-label">Background Image</label>

                            <span class="text-secondary">
                                This Background Image will be displayed in the Login Page.
                            </span>
                        </div>
                    </div>


                    <div class="mb-3">
                        <div class="background-container d-flex align-items-center">

                            <div class="background-img">
                                <img src="http://127.0.0.1:8000/assets/images/vasa.jpg" alt="brand-logo"
                                    accept=".png,.jpg,.jpeg,.bmp">
                            </div>
                            <div class="background-image-pin">
                                <label for="img-pin">
                                    <i class="ri-attachment-line px-1"></i>
                                    <span>
                                        Pick different background</span>&nbsp;

                                    <input type="file" id="background-img" name="background-img" accept=".png,.jpg,.jpeg,.bmp">
                                </label>

                            </div>
                        </div>

                    </div>

                    <div class="mb-3">
                        <div class="intructions-container d-flex flex-column">
                            <label for="logo" class="form-label">Instruction
                                Information</label>
                            <span class="text-secondary">This text will be displayed in the
                                Login Page.</span>


                        </div>

                    </div>

                    <div class="mb-3">
                        <div class="intructions-container d-flex align-items-center">
                            <textarea
                                placeholder="You can provide instructions or similar information not exceeding 250 characters"
                                rows="4" maxlength="250" formcontrolname="loginInstructions"
                                class="form-control " name="login_instructions"></textarea>
                        </div>

                    </div>


                    <div class="mb-3">
                        <div class="buttons-container d-flex align-items-center">
                            <button class="btn btn-default mx-2">Preview</button><button
                                class="btn btn-primary">Save</button>
                        </div>


                    </div>
                </form>
                </div>
            </div>
        </div>


    </div>








    <!-- role -->





</div>
<div style="z-index: 11">
    <div id="borderedToast2" class="toast toast-border-success overflow-hidden mt-3" role="alert" aria-live="assertive" aria-atomic="true" >
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
@endsection
@section('script')

    <!-- ui notifications -->

    <script src="{{ URL::asset('/assets/libs/prismjs/prismjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/notifications.init.js') }}"></script>
    <!-- apexcharts -->

    <script type="text/javascript">



        $('#role-form').on('submit', function(e){
            e.preventDefault();

            //var formData = new FormData(this);
            var roleUri = $('#role-form').attr('action');
            console.log(roleUri);

            $.ajax({
                type: "POST",
                url: roleUri,
                enctype: 'multipart/form-data',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(data)
                {
                  $('#alert-msg').html(data);
                  var toastLiveExample3 = document.getElementById("borderedToast2");
                    var toast = new bootstrap.Toast(toastLiveExample3);
                    toast.show();
                  //alert(data); // show response from the php script.
                }
            })
            //console.log($('#role-form').serialize());
        });

    </script>
@endsection
