@extends('layouts.master')
@section('css')

    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">

@endsection
@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Dashboards @endslot
        @slot('title') 360 Degree Review @endslot
    @endcomponent


    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header border-0 align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Please Fill Form</h4>
                    
                </div><!-- end card header -->

                <div class="card-body  pb-2">
                    <div>
                        <form action="javascript:void(0);" onsubmit="alert('Details submited')">
                            <!-- Que #1 -->
                            @if($formQuestions)
                            @foreach($formQuestions as $index => $formQuestion)

                            <div class="row mb-3">
                                <div class="col-xl-12">
                                    <label class="form-label">
                                        {{($index+1) .'. '.$formQuestion->question}}
                                    </label>
                                    <div class="my-2">
                                        <div class="form-check form-check-inline">
                                            <input id="{{$index.'_1'}}" name="{{'ques['.$formQuestion->id.']'}}" type="radio" class="form-check-input" required value="{{$formQuestion->option_1}}">
                                            <label class="form-check-label" for="{{$index.'_1'}}">
                                                {{$formQuestion->option_1}}
                                            </label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input id="{{$index.'_2'}}" name="{{'ques['.$formQuestion->id.']'}}" type="radio" class="form-check-input" required value="{{$formQuestion->option_2}}">
                                            <label class="form-check-label" for="{{$index.'_2'}}">
                                                {{$formQuestion->option_2}}
                                            </label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input id="{{$index.'_3'}}" name="{{'ques['.$formQuestion->id.']'}}" type="radio" class="form-check-input" required value="{{$formQuestion->option_3}}">
                                            <label class="form-check-label" for="{{$index.'_3'}}">
                                                {{$formQuestion->option_3}}
                                            </label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input id="{{$index.'_4'}}" name="{{'ques['.$formQuestion->id.']'}}" type="radio" class="form-check-input" required value="{{$formQuestion->option_4}}">
                                            <label class="form-check-label" for="{{$index.'_4'}}">
                                                {{$formQuestion->option_4}}
                                            </label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input id="{{$index.'_5'}}" name="{{'ques['.$formQuestion->id.']'}}" type="radio" class="form-check-input" required value="{{$formQuestion->option_5}}">
                                            <label class="form-check-label" for="{{$index.'_5'}}">
                                                {{$formQuestion->option_5}}
                                            </label>
                                        </div>

                                        
                                    </div>
                                </div>
                            </div>

                            @endforeach


                            
                            <div class="row mt-2">
                                <div class="text-end col-xl-12">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                            @else
                                <div class="mb-3 row mt-4">
                                <div class="col-md-12 text-center mb-2 mt-4">
                                   <h5> {{'No Forms Assigned'}}</h5>
                                </div>
                            </div>
                            @endif
                        </form>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->
@endsection
@section('script')
    <!-- apexcharts -->

    <!-- dashboard init -->
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
