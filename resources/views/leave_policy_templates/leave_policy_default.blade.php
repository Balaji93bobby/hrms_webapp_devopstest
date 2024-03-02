@extends('layouts.master')
@section('title')
    @lang('translation.settings')
@endsection
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('/assets/css/leave_policy.css') }}">
@endsection
@section('content')
    <div class="card mt-30 mb-0">
        <div class="card-body">
            <h6>Leave Policy Explanation</h6>


                <div class="text-center">
                    <div class="mx-auto col-md-6">
                        <img src="{{ URL::asset('assets/images/no_dataFile.svg') }}" class="h-100 w-100" alt="user-pic" </div>

                    </div>
                    <h4> <span class="text-orange">Sorry !</span> No data</h4>
                </div>


        </div>
    </div>
@endsection
