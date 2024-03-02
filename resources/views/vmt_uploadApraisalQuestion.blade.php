@extends('layouts.master')
@section('css')

    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">

@endsection
@section('content')

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header border-0 align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"><!-- Please Fill Form --></h4>
                </div><!-- end card header -->

                <div class="card-body  pb-2">
                    <div>
                        @csrf
                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label">Create Single Question</label>
                            <div class="col-md-8">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#createEmployee">Create New
                                    Question</button>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->

    
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header border-0 align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"><!-- Please Fill Form --></h4>
                </div><!-- end card header -->

                <div class="card-body  pb-2">
                    <div>
                        <form method="POST" id='role-form' action="{{url('/vmt-apraisal-question/bulk-upload')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 row">
                                <label class="col-md-2 col-form-label">
                                    Bulk Question Upload
                                </label>
                                <div class="col-md-10">
                                    <input name="file" type="file">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="text-end col-xl-12">
                                    <button type="submit" class="btn btn-primary">  
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->
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




<!-- Create Employee Modal window -->

<div class="modal fade" id="createEmployee">
    <div class="modal-dialog modal-xl" id="" aria-hidden="true"
        aria-labelledby="exampleModalToggleLabel2" tabindex="-1">

        <div class="modal-content">
            <div class="modal-header py-2 bg-primary">

                <div class="w-100 modal-header-content d-flex align-items-center py-2">
                    <h5 class="modal-title text-white" id="exampleModalToggleLabel2">Create New Question
                    </h5>
                    <button 
                        type="button" 
                        class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"
                    >
                    </button>
                </div>
            </div>
            <div class="modal-body">

               
                <form id="newQuestion" method="POST" action="{{url('vmt-apraisal-question/save')}}">
                    @csrf
                  <div class="row">

                    <div class="col-xl-12 mb-3 col-md-12">
                        <label for="dimension" class="form-label">Dimension</label>
                        <input type="text" class="form-control" id="dimension" name="dimension" required>
                    </div>
                    <div class="col-xl-12 mb-3 col-md-12">
                        <label for="kpi" class="form-label">KPI</label>
                        <input type="text" class="form-control" name="kpi" id="kpi" required>
                    </div>
                    <div class="col-xl-12 mb-3 col-md-12">
                        <label for="firstName" class="form-label">Operational Definition</label>
                        <input type="text" class="form-control" name="operational_definition" id="lastName" required>
                    </div>
                    <div class="col-xl-12 mb-3 col-md-12">
                        <label for="firstName" class="form-label">
                            Measure
                        </label>
                        <input 
                            type="text" 
                            class="form-control" id="displayName"
                            name="measure" 
                            required 
                        >
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-3 mb-3 col-md-3 ">

                        <label for="firstName" class="form-label">
                            Frequency
                        </label>
                        <input 
                            type="text" 
                            class="form-control" id="displayName"
                            name="frequency" 
                            required 
                        >
                    </div>
                    <div class="col-xl-3 mb-3 col-md-3">

                        <label for="firstName" class="form-label">
                            Target
                        </label>
                        <input type="text" class="form-control" id="target" name="target" required>


                    </div>
                    <div class="col-xl-3 mb-3 col-md-3">

                        <label for="firstName" class="form-label">
                            Stretch Target
                        </label>
                        <input type="text" class="form-control" id="displayName" name="stretch_target" required>
                    </div>
                    <div class="col-xl-3 mb-3 col-md-3">

                        <label for="firstName" class="form-label">
                            Source
                        </label>
                        <input type="text" class="form-control" id="displayName" name="source" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 mb-3 col-md-12">

                        <label for="firstName" class="form-label">
                            KPI Weightage
                        </label>

                        <input 
                            type="text" 
                            class="form-control" id="displayName" 
                            name="kpi_weightage"
                            required 
                        />
                    </div>
                   
                </div>
                <div class="content-footer">
                    <div class="row">
                        <div class="col-12 ">
                            <div class="d-flex">
                                <ul class="nav nav-pills w-100 mb-4" id="pills-tab"
                                    role="tablist">
                                    <li class="nav-item d-flex w-100 align-items-center justify-content-end "
                                        role="presentation">
                                       
                                        <button class="btn btn-primary waves-effect waves-light"
                                            type="submit">
                                            Save
                                        </button>

                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
                
            </div>
        </div>
    </div>

    <!-- george end -->

    <!-- add employee  Modal-->


</div>






@endsection
@section('script')
    
    <!-- ui notifications -->

    <script src="{{ URL::asset('/assets/libs/prismjs/prismjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/notifications.init.js') }}"></script>
    <!-- apexcharts -->

    <!-- dashboard init -->
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

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


        //$('#newQuestion').on('submit', function(e){
        $(document).on('submit', '#newQuestion', function(e) {
            e.preventDefault();
            var roleUri = $('#newQuestion').attr('action');
            var formObj = $('#newQuestion').serialize();
            $.ajax({
                type: "POST",
                url: roleUri,
                data: formObj,
                success: function(data){
                    //$('#createEmployee').hide();
                    $('#createEmployee').modal('hide')
                    $('#alert-msg').html(data);
                    $('#newQuestion')[0].reset();
                    var toastLiveExample3 = document.getElementById("borderedToast2");
                    var toast = new bootstrap.Toast(toastLiveExample3);
                    toast.show();
                    //alert(data); // show response from the php script.
                }
            })
        });

    </script>
@endsection
