@extends('layouts.master')
@section('css')

    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">

@endsection
@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Dashboards @endslot
        @slot('title') 360 REVIEW MODULE @endslot
    @endcomponent


    <div class="row">
        <div class="col-xl-8">
            <div class="card">

                <div class="card-header border-0 align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">
                    @if(isset($question)) Edit Question @else Create Questions @endif</h4>
                </div><!-- end card header -->
                <div class="card-body  pb-2">
                    <div>
                        <form method="POST" action="{{url('vmt-360-questions/store')}}" id="question-form">
                            @csrf
                            @if(isset($question)) 
                            <input  type="hidden"  name="id" value="{{$question->id}}" >
                            @endif
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label"> Question</label>
                                <div class="col-md-9">
                                    
                                    <textarea class="form-control" placeholder="Enter Questions" id="gen-info-description-input" name="question" rows="2" required>@if(isset($question)) {{$question->question}}  @endif</textarea>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label"> Option 1</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text"  id="example-text-input" placeholder="Enter Option 1" name="option_1" required @if(isset($question)) value="{{$question->option_1}}"  @endif>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label"> Option 2</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text"  id="example-text-input" placeholder="Enter Option 2" name="option_2" @if(isset($question)) value="{{$question->option_2}}"  @endif required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label"> Option 3</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text"  id="example-text-input" placeholder="Enter Option 3" name="option_3" @if(isset($question)) value="{{$question->option_3}}"  @endif required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label"> Option 4</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text"  id="example-text-input" placeholder="Enter Option 4" name="option_4" @if(isset($question)) value="{{$question->option_4}}"  @endif required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label">Option 5</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" id="example-text-input" placeholder="Enter Option 5" name="option_5" @if(isset($question)) value="{{$question->option_5}}"  @endif required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label">Answer</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" id="example-text-input" placeholder="Enter Answer" name="answer" @if(isset($question)) value="{{$question->answer}}"  @endif required>
                                </div>
                            </div>
                            <div class="row mt-2 mb-2">
                                <div class="text-end col-xl-12">
                                    <button type="submit" class="btn btn-primary">@if(isset($question)) Update @else Save @endif </button>
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