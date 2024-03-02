@extends('layouts.master')
@section('css')


@endsection
@section('content')


<div class="container-fluid my-2">
    <h1 style="font-size: 30px;text-align:center;font-weight: 600">You are not authorized to access this page</h1>

    <div class="error-data-wrapper d-flex align-items-center justify-content-center">
       <img src="{{ URL::asset('assets/images/error400-cover.png') }}" alt="" class="h-15 w-15">
    </div>
</div>

@endsection
@section('script')


@endsection
