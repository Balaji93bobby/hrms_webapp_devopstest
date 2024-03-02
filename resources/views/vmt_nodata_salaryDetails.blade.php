@extends('layouts.master')
@section('css')

<link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/hr_dashboard.css') }}" rel="stylesheet">

@endsection
@section('content')
<div class="salary-wrapper mt-30">
    <div class="card shadow profile-box card-top-border ">
        <div class="fill salary-header nav-tab-header">
            <div class="row">
                <div class="col-xs-6">
                    <ul class="nav nav-pills nav-tabs-dashed">
                        <li id="ember76" class="active ember-view">
                            <a href="#/investments-and-proofs/investment-declaration" id="ember77" class="text-muted f-14 fw-bold ember-view">
                                Salary Details
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="zp-container nav-tab-body-top scroll-x scroll-y">
            <div id="ember83" class="ember-view">
                <div class="fill body content">
                    <div class="empty-state-help-centered ind-empty-state d-flex align-items-center justify-content-center flex-column ">
                        <img src="https://css.zohostatic.in/zfpayroll/zpayrollportal///assets/it-empty-state-68d45ef7fddba0f96b1ec6b7664ace53.svg" class="empty-state-image">
                        <div class="empty-state-content">
                            <div class="">
                                <h5> No data</h5>
                            </div>

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
