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
                            <div class="row">
                                <div class="col-xl-12">
                                    <label class="form-label">
                                        1. How likely is it that you would recommend your coworker to a colleague?
                                    </label>
                                    <div class="my-2">
                                        <div class="form-check form-check-inline">
                                            <input id="credit" name="q1" type="radio" class="form-check-input" required>
                                            <label class="form-check-label" for="1">1</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input id="debit" name="q1" type="radio" class="form-check-input" required>
                                            <label class="form-check-label" for="2">2</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input id="paypal" name="q1" type="radio" class="form-check-input" required>
                                            <label class="form-check-label" for="3">3</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input id="paypal" name="q1" type="radio" class="form-check-input" required>
                                            <label class="form-check-label" for="4">4</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input id="paypal" name="q1" type="radio" class="form-check-input" required>
                                            <label class="form-check-label" for="5">5</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Que #2 -->
                            <div class="row mt-3">
                                <div  class="col-xl-12">
                                    <label class="form-label">
                                        2. How often is your coworker late to work?
                                    </label>
                                    <div class="my-2 ">
                                        <div class="form-check form-check-inline col-xl-5">
                                            <input id="credit" name="q2" type="radio" class="form-check-input" required>
                                            <label class="form-check-label" for="1">Always</label>
                                        </div>
                                        <div class="form-check form-check-inline col-xl-4">
                                            <input id="debit" name="q2" type="radio" class="form-check-input" required>
                                            <label class="form-check-label" for="2">Once in a While</label>
                                        </div>
                                        <div class="form-check form-check-inline col-xl-5">
                                            <input id="paypal" name="q2" type="radio" class="form-check-input" required>
                                            <label class="form-check-label" for="3">Most of the time</label>
                                        </div>
                                        <div class="form-check form-check-inline col-xl-4">
                                            <input id="paypal" name="q2" type="radio" class="form-check-input" required>
                                            <label class="form-check-label" for="4">About half the time</label>
                                        </div>
                                        <div class="form-check form-check-inline col-xl-5">
                                            <input id="paypal" name="q2" type="radio" class="form-check-input" required>
                                            <label class="form-check-label" for="5">Never</label>
                                        </div>
                                    </div>
                                </div>
                            </div >
                            <!-- Que #3 -->
                            <div class="row mt-3">
                                <div class="col-xl-12">
                                    <label class="form-label">
                                        3. How much attention to detail does your coworker have?
                                    </label>
                                    <div class="my-2 ">
                                        <div class="form-check form-check-inline col-xl-5">
                                            <input id="credit" name="q3" type="radio" class="form-check-input" required>
                                            <label class="form-check-label" for="1">A great deal of attention</label>
                                        </div>
                                        <div class="form-check form-check-inline col-xl-4">
                                            <input id="debit" name="q3" type="radio" class="form-check-input" required>
                                            <label class="form-check-label" for="2">A little attention</label>
                                        </div>
                                        <div class="form-check form-check-inline col-xl-5">
                                            <input id="paypal" name="q3" type="radio" class="form-check-input" required>
                                            <label class="form-check-label" for="3">A lot of attention</label>
                                        </div>
                                        <div class="form-check form-check-inline col-xl-6">
                                            <input id="paypal" name="q3" type="radio" class="form-check-input" required>
                                            <label class="form-check-label" for="4">A moderate amount of attention</label>
                                        </div>
                                        <div class="form-check form-check-inline col-xl-5">
                                            <input id="paypal" name="q3" type="radio" class="form-check-input" required>
                                            <label class="form-check-label" for="5">Not any attention at all</label>
                                        </div>
                                    </div>
                                </div>
                            </div >
                            <!-- Que #4 -->
                            <div class="row mt-3">
                                <div class="col-xl-12">
                                    <label class="form-label">
                                        4. How often does your coworker meet his/her deadlines?
                                    </label>
                                    <div class="my-2">
                                        <div class="form-check form-check-inline col-xl-5">
                                            <input id="que-41" name="deadlines" type="radio" class="form-check-input" required>
                                            <label class="form-check-label" for="1">Always</label>
                                        </div>
                                        <div class="form-check form-check-inline col-xl-4">
                                            <input id="que-42" name="deadlines" type="radio" class="form-check-input" required>
                                            <label class="form-check-label" for="2">Once in a whilte</label>
                                        </div>
                                        <div class="form-check form-check-inline col-xl-5">
                                            <input id="que-43" name="deadlines" type="radio" class="form-check-input" required>
                                            <label class="form-check-label" for="3">Most of the time</label>
                                        </div>
                                        <div class="form-check form-check-inline col-xl-6">
                                            <input id="que-44" name="deadlines" type="radio" class="form-check-input" required>
                                            <label class="form-check-label" for="4">About half of the time</label>
                                        </div>
                                        <div class="form-check form-check-inline col-xl-5">
                                            <input id="que-45" name="deadlines" type="radio" class="form-check-input" required>
                                            <label class="form-check-label" for="5">Never</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Que #5 -->
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <label class="form-label">
                                        5. What does your coworker need to do to improve his/her performance?
                                    </label>
                                    <div class="my-2">
                                        <textarea class="form-control" placeholder="Enter Description" id="gen-info-description-input" name="performance" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="text-end col-xl-12">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->
@endsection
@section('script')
    <!-- apexcharts -->

@endsection
