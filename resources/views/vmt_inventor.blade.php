@extends('layouts.master')
@section('css')
<link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/onboarding.css') }}">
@endsection
@section('content')


<div class="container-fluid pms-dashboard">
    <div class="card px-5 py-2 pms-card-wrapper  pms-dashboard-wrapper ">


        <div class="card-body p-5">
            <!-- <div class="row ">
                <div class="col-md-4 col-sm-6 col-lg-3 col-xl-3 "> -->

            <div class="d-flex  flex-wrap align-items-center justify-content-center inside-pms-container">
                <div class="card pms-card m-0 m-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <img src="{{ URL::asset('assets/images/self_review.png') }}" alt="" class="">
                            <p>Self Review</p>
                        </div>
                    </div>
                </div>

                <div class="card pms-card m-0 m-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <img src="{{ URL::asset('assets/images/rating_assessment.png') }}" alt="" class="">
                            <p>Rating assessment reminder notiﬁcation</p>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-4 col-sm-6 col-lg-3 col-xl-3 "> -->
                <div class="card pms-card m-0 m-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <img src="{{ URL::asset('/assets/images/goals_assignment.png')}}" class="rounded-circle">
                            <p>Goals assignment reminder notiﬁcation</p>
                        </div>
                        <!-- </div> -->
                    </div>
                </div>
                <!-- <div class="col-md-4 col-sm-6 col-lg-3 col-xl-3 "> -->
                <div class="card pms-card m-0 m-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <img src="{{ URL::asset('/assets/images/manager_review.png')}}" class="">
                            <p>Manager Review</p>

                        </div>
                        <!-- </div> -->

                    </div>
                </div>
                <!-- <div class="col-md-4 col-sm-6 col-lg-3 col-xl-3 "> -->
                <div class="card pms-card m-0 m-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <img src="{{ URL::asset('/assets/images/org.png')}}" class="">
                            <p>Organisation Review</p>
                        </div>
                    </div>

                </div>
                <div class="card pms-card m-0 m-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <img src="{{ URL::asset('/assets/images/employee_goals.png')}}" class="">
                            <p>Employee Goals</p>
                        </div>
                    </div>

                </div>
                <div class="card pms-card m-0 m-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <img src="{{ URL::asset('/assets/images/employees_assessed.png')}}" class="">
                            <p>Employees Assessed</p>
                        </div>
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
@endsection
