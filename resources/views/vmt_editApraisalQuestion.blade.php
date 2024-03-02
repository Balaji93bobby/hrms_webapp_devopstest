@extends('layouts.master')
@section('css')

    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">

@endsection


@section('content')

    


    <div class="row">
        <div class="col-xl-8">
            <div class="card">

                <div class="card-header border-0 align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">
                    Edit Question </h4>
                </div><!-- end card header -->
                <div class="card-body  pb-2">
                    <div>
                       
                        <form id="question-form" method="POST" action="{{url('vmt-apraisal-question/update/'.$question->id)}}">
                    @csrf
                  <div class="row">

                    <div class="col-xl-12 mb-3 col-md-12">
                        <label for="dimension" class="form-label">Dimension</label>
                        <input type="text" class="form-control" id="dimension" name="dimension" required value="{{$question->dimension}}">
                    </div>
                    <div class="col-xl-12 mb-3 col-md-12">
                        <label for="kpi" class="form-label">KPI</label>
                        <input type="text" class="form-control" name="kpi" id="kpi" required value="{{$question->kpi}}">
                    </div>
                    <div class="col-xl-12 mb-3 col-md-12">
                        <label for="firstName" class="form-label">Operational Definition</label>
                        <input type="text" class="form-control" name="operational_definition" id="lastName" required value="{{$question->operational_definition}}" >
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
                            value="{{$question->measure}}" 
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
                            value="{{$question->frequency}}" 
                        >
                    </div>
                    <div class="col-xl-3 mb-3 col-md-3">

                        <label for="firstName" class="form-label">
                            Target
                        </label>
                        <input type="text" 
                        value="{{$question->target}}"  class="form-control" id="target" name="target" required>


                    </div>
                    <div class="col-xl-3 mb-3 col-md-3">

                        <label for="firstName" class="form-label">
                            Stretch Target
                        </label>
                        <input type="text" class="form-control" id="displayName" name="stretch_target" value="{{$question->stretch_target}}"  required>
                    </div>
                    <div class="col-xl-3 mb-3 col-md-3">

                        <label for="firstName" class="form-label">
                            Source
                        </label>
                        <input type="text" value="{{$question->source}}"  class="form-control" id="displayName" name="source" required>
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
                            value="{{$question->kpi_weightage}}" 
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
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->

    <!-- Display Toast Notification Bordered With Icon Toast -->
    <div style="z-index: 11">
        <div id="borderedToast2" class="toast toast-border-success overflow-hidden mt-3" role="alert" aria-live="assertive" aria-atomic="true">
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
    <!-- dashboard init -->
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        // Save Questions
        $('#question-form').on('submit', function(e){
            e.preventDefault();
            var roleUri = $('#question-form').attr('action');
            $.ajax({
                type: "POST",
                url: roleUri,
                data: $('#question-form').serialize(), // serializes the form's elements.
                success: function(data)
                {
                    $('#alert-msg').html(data);
                    var toastLiveExample3 = document.getElementById("borderedToast2");
                    var toast = new bootstrap.Toast(toastLiveExample3);
                    toast.show();
                }
            })
        });

    </script>
@endsection