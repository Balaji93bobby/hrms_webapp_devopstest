@extends('layouts.master')
@section('title') @lang('translation.dashboards') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/libs/swiper/swiper.min.css')}}" rel="stylesheet" type="text/css" />


<!-- prem content -->

    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/bootstrap.min.css') }}">

    <!--Custom style.css-->
    <link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/quicksand.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/dashboard.css') }}">
    <!--Bootstrap Calendar-->
    <!-- <link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/bootstrap_calendar.css') }}"> -->

    <!--Font Awesome-->
    <link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/fontawesome.css') }}">
    <!--Animate CSS-->
    <link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/chartist.min.css') }}">
    <!--Map-->
    <link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/jquery-jvectormap-2.0.2.css') }}">

    
    <!-- calendar -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<!-- prem content end -->


@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Dashboards @endslot
@slot('title') Dashboard @endslot
@endcomponent


    <div class="main">
        <div class="">
            <div class="row ml-1 mt-1">
                <div class="col-sm-6 col-md-6 ipad-query">
                    <div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border" style="height:95%;">
                        <div class="row pl-2 pr-2 media-query" style="height:100%;">
                            <div class="col-sm-6 col-md-6">
                                <div class="row mt-2">
                                    <p class="pl-3 col-auto"><img src="{{ URL::asset('/assets/premassets/img/client-img5.png') }}" class="img-round"></p>
                                    <div class="pt-2 col">
                                        <h6><b>{{Admin}}</b></h6>
                                        <p class="text-muted f-13 m-0">CRT234</p>
                                        <p class="text-muted f-13">Software engineer</p>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <h6 class="col f-15 wrap-text"><span><i class="fa fa-sun mr-1"></i>Day shift</span></h6>
                                    <h6 class="f-15 col-auto wrap-text"><div class="text-right"><i class="fa fa-clock mr-1"></i>9:00 AM - 18:00PM</div></h6>
                                </div>
                                <div class="row mt-2">
                                    <h6 class="col f-15 wrap-text">Monday-14<sup>th</sup> June 2019</h6>
                                    <h6 class="f-15 col-auto wrap-text text-danger"><div class="text-right">17:30:59</div></h6>
                                </div>
                                <div class="row mt-2">
                                    <h6 class="col f-15 wrap-text"><label class="switch"> <input type="checkbox"> <span class="slider round"><span class="slider-text">Check in</span></span> </label> </h6>
                                    <h6 class="f-15 col-auto wrap-text text-danger"><div class="text-right">02:20:59</div></h6>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="bg-muted pl-2 pr-2">
                                    <div class="row pt-3">
                                        <h6 class="mr-1 col f-15 pr-0"><b class=""><span class="mr-1"><img src="{{ URL::asset('/assets/premassets/img/rabbit.jpeg') }}" style="width:20%;height:100%;"></span>At work 10</b></h6>
                                        <h6 class="f-15 col pl-0 wrap-text"><div class="text-right" style="width:100%;overflow:hidden;text-overflow:ellipsis;"><b ><span class="mr-1"><img src="{{ URL::asset('/assets/premassets/img/tourtoi.jpeg') }}" style="width:25%;height:25%;"></span>Late 2/3</b></div></h6>
                                    </div>
                                    <div class="row mt-3">
                                        <h6 class="mr-1 col-auto f-15 pr-0 wrap-text" style="width: 60%;"><i class="fa fa-circle f-11 mr-2 text-danger"></i>Sick Leave</h6>
                                        <h6 class="f-15 col text-danger pl-0">
                                            <div class="text-right">
                                                <div class="progress"> 
                                                    <div class="color " style="background:red;width:10%;"></div>
                                                </div>
                                                <span>1/9</span>
                                            </div>
                                        </h6>
                                    </div>
                                    <div class="row mt-2">
                                        <h6 class="mr-1 col-auto f-15 pr-0 wrap-text" style="width: 60%;"><i class="fa fa-circle f-11 mr-2 text-purple"></i>Casual Leave</h6>
                                        <h6 class="f-15 col text-danger pl-0">
                                            <div class="text-right">
                                                <div class="progress"> 
                                                    <div class="color " style="background:lightgreen;width:100%;"></div>
                                                </div>
                                                <span>9/9</span>
                                            </div>
                                        </h6>
                                    </div>
                                    <div class="row mt-2">
                                        <h6 class="mr-1 col-auto f-15 pr-0 wrap-text" style="width: 60%;"><i class="fa fa-circle f-11 mr-2 text-yellow"></i>LOP</h6>
                                        <h6 class="f-15 col text-danger pl-0">
                                            <div class="text-right">
                                                <div class="progress"> 
                                                    <div class="color " style="background:yellow;width:90%;"></div>
                                                </div>
                                                <span>8/9</span>
                                            </div>
                                        </h6>
                                    </div>
                                    <div class="row mt-2">
                                        <h6 class="mr-1 col-auto f-15 pr-0 wrap-text" style="width: 60%;"><i class="fa fa-circle f-11 mr-2 text-lightblue"></i>Compensatory Off</h6>
                                        <h6 class="f-15 col text-danger pl-0">
                                            <div class="text-right">
                                                <div class="progress"> 
                                                    <div class="color " style="background:lightgreen;width:100%;"></div>
                                                </div>
                                                <span>1/1</span>
                                            </div>
                                        </h6>
                                    </div>
                                    <div class="row mt-2">
                                        <h6 class="mr-1 col-auto f-15 pr-0 wrap-text" style="width: 60%;"><i class="fa fa-circle f-11 mr-2 text-secondary"></i>Flexi Day Off</h6>
                                        <h6 class="f-15 col text-danger pl-0">
                                            <div class="text-right">
                                                <div class="progress"> 
                                                    <div class="color " style="background:lightgreen;width:100%;"></div>
                                                </div>
                                                <span>2/2</span>
                                            </div>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 ipad-query">
                    <div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border" style="height:95%;">
                        <div class="row pl-2 pr-2 media-query" style="height:100%">
                            <div class="col-sm-6 col-md-6">
                                <div class="">
                                    <h6 style="justify-content: center; align-items: center; display: inline-flex; "><b><i class="fa fa-circle-o mr-1 text-purple"></i>My Holidays</b><span class="text-muted f-11 mr-2"> - 2020</span></h6>
                                </div>
                                <div class="bg-muted" style="height:calc(100% - 2em);overflow:auto;">
                                    <div class="row pl-3 pt-3" style="width:100%">
                                        <h6 class="mr-1 pl-3 f-11"><b><span data-text="Thanks for hovering! I'm a tooltip" class="tool-title cursor-pointer rounded-circle text-danger mr-3 f-13" style="background:orange;">M</span><span class="wrap-text" style="width:75%;">Sun, 26 Jan<span class="ml-3">Republic Day</span></span></b></h6>
                                    </div>
                                    <div class="row pl-3 pt-3" style="width:100%">
                                        <h6 class="mr-1 pl-3 f-11"><b><span data-text="Thanks for hovering! I'm a tooltip" class="tool-title cursor-pointer rounded-circle text-secondary mr-3 f-13" style="background:lightblue;">H</span><span class="wrap-text" style="width:75%;">Fri, 10 APr <span class="ml-3">Good Friday</span></span></b></h6>
                                    </div>
                                    <div class="row pl-3 pt-3" style="width:100%">
                                        <h6 class="mr-1 pl-3 f-11"><b><span data-text="Thanks for hovering! I'm a tooltip" class="tool-title cursor-pointer rounded-circle text-danger mr-3 f-13" style="background:orange;">M</span><span class="wrap-text" style="width:75%;">Fri,2 - Mon, 5 Oct<span class="ml-3">Pooja Holidays</span></span></b></h6>
                                    </div>
                                    <div class="row pl-3 pt-3" style="width:100%">
                                        <h6 class="mr-1 pl-3 f-11"><b><span data-text="Thanks for hovering! I'm a tooltip" class="tool-title cursor-pointer rounded-circle text-secondary mr-3 f-13" style="background:lightblue;">H</span><span class="wrap-text" style="width:75%;">Sun, 25 Oct <span class="ml-3">Dussehra</span></span></b></h6>
                                    </div>
                                    <div class="row pl-3 pt-3" style="width:100%">
                                        <h6 class="mr-1 pl-3 f-11"><b><span data-text="Thanks for hovering! I'm a tooltip" class="tool-title cursor-pointer rounded-circle text-secondary mr-3 f-13" style="background:lightblue;">H</span><span class="wrap-text" style="width:75%;">Tue, 12 Oct <span class="ml-3">Prophet's Birthday</span></span></b></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="row">
                                    <h6 class="mr-1 col-sm-6 col-md-6 col-xs-6 pr-0"><b class="wrap-text"><i class="fa fa-circle-o mr-1 text-danger"></i>My Calendar</b></h6>
                                </div>
                                <div id='full_calendar_events'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ml-1 mt-1">
                <div class="col-sm-6 col-md-6 ipad-query">
                    <div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border" style="height:95%;">
                        <div class="row pl-2 pr-2 media-query">
                            <div class="col-sm-5 col-md-5">
                                <div class="bg-muted">
                                    <div class="pl-3">
                                        <h6 style="justify-content: center; align-items: center; display: inline-flex; "><b><i class="fa fa-circle-o mr-1 text-purple"></i>My Utilization</b></h6>
                                    </div>
                                    <div class="text-center pt-3">
                                        <div id="donutChartEcharts" style="height: 300px; width: 100%"></div>
                                    </div>
                                    <div class="text-center pt-3" style="width:100%">
                                        <h6 class="mr-1 pl-3 f-15"><i class="fa fa-circle text-success mr-1 f-13"></i>My total working days<span class="ml-1 text-danger"><b>50</b></span></h6>
                                        <h6 class="mr-1 pl-3 f-13 text-muted">Organization working days 100</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-7 col-md-7">
                                <div class="row">
                                    <div class="col-12 pr-0">
                                        <h6><b><i class="fa fa-circle-o mr-1 text-yellow"></i>My Time Off</b></h6>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <div class="bg-box-color p-1">
                                        <div class="row pl-2 mt-2" style="justify-content:space-between;width:100%">
                                            <div class="d-flex col" style="width:80%;">
                                                <h6 class="mr-1 f-15 clock-center"><span class="rounded-circle-box mr-3 f-13 text-primary" style="background:orange;"><i class="fa fa-clock text-danger"></i></span></h6>
                                                <span class="">
                                                    <p class="f-13 m-0"><b>Sick time off</b></p>
                                                    <p class="text-muted f-13"><b class="mr-1">3days</b>- 2 No 2019 - 4 Nov 2019</p>
                                                </span>
                                            </div>
                                            <h6 class="f-15 col-auto text-success content-query pr-0">
                                                Success
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <div class="bg-box-color p-1">
                                        <div class="row pl-2 mt-2" style="justify-content:space-between;width:100%">
                                            <div class="d-flex col" style="width:80%;">
                                                <h6 class="mr-1 f-15 clock-center"><span class="rounded-circle-box mr-3 f-13 text-primary" style="background:lightblue;"><i class="fa fa-clock text-danger"></i></span></h6>
                                                <span class="">
                                                    <p class="f-13 m-0"><b>Sick time off</b></p>
                                                    <p class="text-muted f-13"><b class="mr-1">1:00 Hours</b>12:00PM-01:00PM-2 Nov 2019</p>
                                                </span>
                                            </div>
                                            <h6 class="f-15 col-auto text-danger content-query pr-0">
                                                Reject
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <div class="bg-box-color p-1">
                                        <div class="row pl-2 mt-2" style="justify-content:space-between;width:100%">
                                            <div class="d-flex col" style="width:80%;">
                                                <h6 class="mr-1 f-15 clock-center"><span class="rounded-circle-box mr-3 f-13 text-primary" style="background:orange;"><i class="fa fa-clock text-danger"></i></span></h6>
                                                <span class="">
                                                    <p class="f-13 m-0"><b>Compensatory time off</b></p>
                                                    <p class="text-muted f-13"><b class="mr-1">3days</b>- 2 No 2019 - 4 Nov 2019</p>
                                                </span>
                                            </div>
                                            <h6 class="f-15 col-auto text-primary content-query pr-0">
                                                Pending
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 pl-0" style="float: right;">
                                    <h6>
                                        <a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <p class="dropdown-apply"><i class="fa fa-plus f-15 rounded-plus bg-primary text-white"></i><span class="mt-1">Apply</span><i class="fa fa-chevron-down f-15 text-primary pt-1"></i></p>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right m-0" id="apply-dropdown" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item f-11" href="#"> Time off</a>
                                            <a class="dropdown-item f-11" href="#"> Short time Off</a>
                                            <a class="dropdown-item f-11" href="#"> Compensatory time off</a>
                                        </div>                                                  
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 ipad-query">
                    <div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border" style="height:95%;">
                        <div class="row pl-2 pr-2 media-query">
                            <div class="col-sm-12 col-md-12">
                                <div class="mt-2 pt-1 pl-1">
                                    <h6 style="justify-content: center; align-items: center; display: inline-flex; "><b><span class="blink_me rounded-blinking-ring1"></span><span class="blink_me rounded-blinking-ring"></span><span class="blink_me rounded-blinking bg-primary"></span><span class="mr-1 ring-number">5</span><span class="ml-5">My Actions</span></b></h6>
                                </div>
                                <div class="mt-2">
                                    <div class="bg-box-color p-1">
                                        <div class="row pl-2 mt-2" style="justify-content:space-between;width:100%">
                                            <div class="d-flex col" style="width:80%;">
                                                <h6 class="mr-1 f-15 clock-center"><span class="rounded-circle-box mr-3 f-13 text-danger" style="background:lightgreen;"><i class="fa fa-power-off" style="color:green;"></i></span></h6>
                                                <span class="">
                                                    <p class="f-13 m-0"><b>5 Nov 2019</b></p>
                                                    <p class="text-muted f-13">You missed<b class="ml-1 mr-1 text-success">Check-in</b>and<b class="text-danger ml-1">Check-Out</b></p>
                                                </span>
                                            </div>
                                            <h6 class="f-11 clock-center col-auto pr-0">
                                                <span class="p-2" style="background:pink;">
                                                    Enter your name
                                                </span>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <div class="bg-box-color p-1">
                                        <div class="row pl-2 mt-2" style="justify-content:space-between;width:100%">
                                            <div class="d-flex col" style="width:80%;">
                                                <h6 class="mr-1 f-15 clock-center"><span class="rounded-circle-box mr-3 f-13 text-danger" style="background:pink;"><i class="fa fa-power-off text-danger"></i></span></h6>
                                                <span class="">
                                                    <p class="f-13 m-0"><b>6 Nov 2019</b></p>
                                                    <p class="text-muted f-13">You missed<b class="ml-1 mr-1 text-success">Check-in</b></p>
                                                </span>
                                            </div>
                                            <h6 class="f-11 clock-center col-auto pr-0">
                                                <span class="p-2" style="background:pink;">
                                                    Enter your name
                                                </span>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <div class="bg-box-color p-1">
                                        <div class="row pl-2 mt-2" style="justify-content:space-between;width:100%">
                                            <div class="d-flex col" style="width:80%;">
                                                <h6 class="mr-1 f-15 clock-center"><span class="rounded-circle-box mr-3 f-13 text-primary" style="background:lightgreen;"><i class="fa fa-power-off" style="color:green;"></i></span></h6>
                                                <span class="">
                                                    <p class="f-13 m-0"><b>5 Nov 2019</b></p>
                                                    <p class="text-muted f-13">You missed<b class="ml-1 mr-1 text-success">Check-in</b>and<b class="text-danger ml-1">Check-Out - 07:00 PM</b></p>
                                                </span>
                                            </div>
                                            <h6 class="f-15 text-primary content-query col-auto pr-0">
                                                Pending
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ml-1 mt-1">
                <div class="col-sm-6 col-md-6 ipad-query">
                    <div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border" style="height:95%;" style="height: 300px; overflow: auto;">
                        <div class="row pl-2 pr-2 media-query">
                            <div class="col-sm-12 col-md-12">
                                <div style="position: absolute;right: -2px;top: -7px;"><span class="rounded-circle text-danger f-13" style="background: pink;"><i class="fa fa-refresh text-danger"></i></span></div>
                                <div class="">
                                    <h6 style="justify-content: center; align-items: center; display: inline-flex; "><b class="mr-2"><i class="fa fa-circle-o mr-1 text-success"></i>My Company Updates</b>
                                        <span class="f-11 active-emp p-1"><i class="fa fa-circle f-13 text-success mr-1"></i>Active Employees - <b class="mr-1">100/1000</b></span>
                                    </h6>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-sm-3 col-md-3 pt-4 pr-0">
                                        <div class="bg-box-color p-1" style="width:100%;word-break: break-word; white-space: normal;">
                                            <div class="row">
                                                <h6 class="f-15 col-5 mt-2"><span class="rounded-circle-box mr-2 f-13 text-danger" style="background:pink;"><i class="fa fa-gift text-danger"></i></span></h6>
                                                <p class="f-13 m-0 col-7 pl-0"><b>Upcoming birthday</b></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-9 col-md-9">
                                        <div class="menu-wrapper">
                                            <ul class="menu" id="picture-scroll" picLength="6">
                                                <li class="item">
                                                    <div class="row m-0">
                                                        <div class="col-12 p-0"><p class=""><img src="{{ URL::asset('/assets/premassets/img/frontend.jpg') }}" class="img-rounded"></p></div>
                                                        <div class="col-12 p-0">
                                                            <p class="m-0 f-11"><b>Kobus</b></p>
                                                            <p class="text-muted f-11">2 Nov</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="item">
                                                    <div class="row m-0">
                                                        <div class="col-12 p-0"><p class=""><img src="{{ URL::asset('/assets/premassets/img/client-img2.png') }}" class="img-rounded"></p></div>
                                                        <div class="col-12 p-0">
                                                            <p class="m-0 f-11"><b>Kobus</b></p>
                                                            <p class="text-muted f-11">2 Nov</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="item">
                                                    <div class="row m-0">
                                                        <div class="col-12 p-0"><p class=""><img src="{{ URL::asset('/assets/premassets/img/client-img3.png') }}" class="img-rounded"></p></div>
                                                        <div class="col-12 p-0">
                                                            <p class="m-0"><b class="f-11"><b>Kobus</b></b></p>
                                                            <p class="text-muted f-11">2 Nov</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="item">
                                                    <div class="row m-0">
                                                        <div class="col-12 p-0"><p class=""><img src="{{ URL::asset('/assets/premassets/img/client-img4.png') }}" class="img-rounded"></p></div>
                                                        <div class="col-12 p-0">
                                                            <p class="m-0"><b class="f-11"><b>Kobus</b></b></p>
                                                            <p class="text-muted f-11">2 Nov</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="item">
                                                    <div class="row m-0">
                                                        <div class="col-12 p-0"><p class=""><img src="{{ URL::asset('/assets/premassets/img/client-img5.png') }}" class="img-rounded"></p></div>
                                                        <div class="col-12 p-0">
                                                            <p class="m-0"><b class="f-11"><b>Kobus</b></b></p>
                                                            <p class="text-muted f-11">2 Nov</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="item">
                                                    <div class="row m-0">
                                                        <div class="col-12 p-0"><p class=""><img src="{{ URL::asset('/assets/premassets/img/client-img2.png') }}" class="img-rounded"></p></div>
                                                        <div class="col-12 p-0">
                                                            <p class="m-0"><b class="f-11"><b>Kobus</b></b></p>
                                                            <p class="text-muted f-11">2 Nov</p>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="paddles">
                                                <button class="left-paddle paddle hidden">
                                                    <
                                                </button>
                                                <button class="right-paddle paddle">
                                                    >
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="m-0">
                                <div class="row mt-2">
                                    <div class="col-sm-3 col-md-3 pt-4 pr-0">
                                        <div class="bg-box-color p-1" style="width:100%;word-break: break-word; white-space: normal;">
                                            <div class="row">
                                                <h6 class="f-15 col-5 mt-2"><span class="rounded-circle-box mr-2 f-13 text-danger" style="background:pink;"><i class="fa fa-user text-danger"></i></span></h6>
                                                <p class="f-13 m-0 col-7 pl-0"><b>New Joiners</b></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-9 col-md-9">
                                        <div class="menu-wrapper-joiner">
                                            <ul class="menu-joiner" id="picture-scroll-joiner" picLength="12">
                                                <li class="item-joiner">
                                                    <div class="row m-0">
                                                        <div class="col-12 p-0"><p class=""><img src="{{ URL::asset('/assets/premassets/img/frontend.jpg') }}" class="img-rounded"></p></div>
                                                        <div class="col-12 p-0">
                                                            <p class="m-0 f-11"><b>Kobus</b></p>
                                                            <p class="text-muted f-11">2 Nov</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="item-joiner">
                                                    <div class="row m-0">
                                                        <div class="col-12 p-0"><p class=""><img src="{{ URL::asset('/assets/premassets/img/client-img2.png') }}" class="img-rounded"></p></div>
                                                        <div class="col-12 p-0">
                                                            <p class="m-0 f-11"><b>Kobus</b></p>
                                                            <p class="text-muted f-11">2 Nov</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="item-joiner">
                                                    <div class="row m-0">
                                                        <div class="col-12 p-0"><p class=""><img src="{{ URL::asset('/assets/premassets/img/client-img3.png') }}" class="img-rounded"></p></div>
                                                        <div class="col-12 p-0">
                                                            <p class="m-0"><b class="f-11"><b>Kobus</b></b></p>
                                                            <p class="text-muted f-11">2 Nov</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="item-joiner">
                                                    <div class="row m-0">
                                                        <div class="col-12 p-0"><p class=""><img src="{{ URL::asset('/assets/premassets/img/client-img4.png') }}" class="img-rounded"></p></div>
                                                        <div class="col-12 p-0">
                                                            <p class="m-0"><b class="f-11"><b>Kobus</b></b></p>
                                                            <p class="text-muted f-11">2 Nov</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="item-joiner">
                                                    <div class="row m-0">
                                                        <div class="col-12 p-0"><p class=""><img src="{{ URL::asset('/assets/premassets/img/client-img5.png') }}" class="img-rounded"></p></div>
                                                        <div class="col-12 p-0">
                                                            <p class="m-0"><b class="f-11"><b>Kobus</b></b></p>
                                                            <p class="text-muted f-11">2 Nov</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="item-joiner">
                                                    <div class="row m-0">
                                                        <div class="col-12 p-0"><p class=""><img src="{{ URL::asset('/assets/premassets/img/client-img2.png') }}" class="img-rounded"></p></div>
                                                        <div class="col-12 p-0">
                                                            <p class="m-0"><b class="f-11"><b>Kobus</b></b></p>
                                                            <p class="text-muted f-11">2 Nov</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="item-joiner">
                                                    <div class="row m-0">
                                                        <div class="col-12 p-0"><p class=""><img src="{{ URL::asset('/assets/premassets/img/client-img3.png') }}" class="img-rounded"></p></div>
                                                        <div class="col-12 p-0">
                                                            <p class="m-0"><b class="f-11"><b>Kobus</b></b></p>
                                                            <p class="text-muted f-11">2 Nov</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="item-joiner">
                                                    <div class="row m-0">
                                                        <div class="col-12 p-0"><p class=""><img src="{{ URL::asset('/assets/premassets/img/client-img4.png') }}" class="img-rounded"></p></div>
                                                        <div class="col-12 p-0">
                                                            <p class="m-0"><b class="f-11"><b>Kobus</b></b></p>
                                                            <p class="text-muted f-11">2 Nov</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="item-joiner">
                                                    <div class="row m-0">
                                                        <div class="col-12 p-0"><p class=""><img src="{{ URL::asset('/assets/premassets/img/client-img5.png') }}" class="img-rounded"></p></div>
                                                        <div class="col-12 p-0">
                                                            <p class="m-0"><b class="f-11"><b>Kobus</b></b></p>
                                                            <p class="text-muted f-11">2 Nov</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="item-joiner">
                                                    <div class="row m-0">
                                                        <div class="col-12 p-0"><p class=""><img src="{{ URL::asset('/assets/premassets/img/client-img3.png') }}" class="img-rounded"></p></div>
                                                        <div class="col-12 p-0">
                                                            <p class="m-0"><b class="f-11"><b>Kobus</b></b></p>
                                                            <p class="text-muted f-11">2 Nov</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="item-joiner">
                                                    <div class="row m-0">
                                                        <div class="col-12 p-0"><p class=""><img src="{{ URL::asset('/assets/premassets/img/client-img4.png') }}" class="img-rounded"></p></div>
                                                        <div class="col-12 p-0">
                                                            <p class="m-0"><b class="f-11"><b>Kobus</b></b></p>
                                                            <p class="text-muted f-11">2 Nov</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="item-joiner">
                                                    <div class="row m-0">
                                                        <div class="col-12 p-0"><p class=""><img src="{{ URL::asset('/assets/premassets/img/client-img5.png') }}" class="img-rounded"></p></div>
                                                        <div class="col-12 p-0">
                                                            <p class="m-0"><b class="f-11"><b>Kobus</b></b></p>
                                                            <p class="text-muted f-11">2 Nov</p>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="paddles-joiner">
                                                <button class="left-paddle-joiner paddle-joiner hidden">
                                                    <
                                                </button>
                                                <button class="right-paddle-joiner paddle-joiner">
                                                    >
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--Main Content-->



<!--  -->
@endsection

@section('script')
<!-- Prem assets -->
    <!-- OWL CAROUSEL -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>

   <script src="{{ URL::asset('/assets/premassets/js/jquery-1.12.4.min.js') }}"></script>
    <!--Popper JS-->
    <script src="{{ URL::asset('/assets/premassets/js/popper.min.js') }}"></script>
    <!--Bootstrap-->
    <script src="{{ URL::asset('/assets/premassets/js/bootstrap.min.js') }}"></script>
    <!--Sweet alert JS-->
    <script src="{{ URL::asset('/assets/premassets/js/sweetalert.js') }}"></script>
    <script src="{{ URL::asset('/assets/premassets/js/progressbar.min.js') }}"></script>
    <!--Flot.JS-->
    <script src="{{ URL::asset('/assets/premassets/js/charts/jquery.flot.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/premassets/js/charts/jquery.flot.pie.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/premassets/js/charts/jquery.flot.categories.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/premassets/js/charts/jquery.flot.stack.min.js') }}"></script>
    <!--Echarts-->
    <script src="{{ URL::asset('/assets/premassets/js/charts/echarts.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/premassets/js/charts/echarts-data.js') }}"></script>
    <!--Charts JS-->
    <script src="{{ URL::asset('/assets/premassets/js/charts/chart.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/premassets/js/charts/demo.js') }}"></script>
    <!--Maps-->
    <script src="{{ URL::asset('/assets/premassets/js/maps/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/premassets/js/maps/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ URL::asset('/assets/premassets/js/maps/jvector-maps.js') }}"></script>
    <!--Bootstrap Calendar JS-->
    <!-- <script src="{{ URL::asset('/assets/premassets/js/calendar/bootstrap_calendar.js') }}"></script>
    <script src="{{ URL::asset('/assets/premassets/js/calendar/demo.js') }}"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <!--Nice select-->
    <script src="{{ URL::asset('/assets/premassets/js/jquery.nice-select.min.js') }}"></script>

    <!--Custom Js Script-->
    <script src="{{ URL::asset('/assets/premassets/js/custom.js') }}"></script>
    <script src="{{ URL::asset('/assets/premassets/js/dashboard.js') }}"></script>


<!-- Prem assets ends -->

<!-- apexcharts -->
<script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/jsvectormap/jsvectormap.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/swiper/swiper.min.js')}}"></script>
<!-- dashboard init -->
<script src="{{ URL::asset('/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

<!-- for date and time -->

<script>
// var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
// var d = new Date(dateString);
// var dayName = days[d.getDay()];
// var dayIndex = new Date().getDay();
// const getDayName = (dayIndex) => {
//     const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
//     return days[dayIndex];
// }
// const dayName = getDayName(dayIndex)
// const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
//     "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
// ];

// const d = new Date();

// document.getElementById("displayDay").innerHTML = monthNames[d.getMonth()] + " " + d.getDate() + "," + d.getFullYear() + " " + dayName;


// function displayTimes() {

//     var date = new Date();
//     var hrs = date.getHours();
//     var mins = date.getMinutes();
//     var secs = date.getSeconds();

//     var sessions = document.getElementById("session");

//     if (hrs > 12) {
//         session.innerHTML = "PM";

//     } else {
//         session.innerHTML = "PM";
//     }

//     if (hrs > 12) {
//         hrs = hrs - 12;
//     }

//     if (mins <= 9) {
//         mins = "0" + mins;
//     }
//     if (secs <= 9) {
//         secs = "0" + secs;
//     }

//     document.getElementById("time").innerHTML = hrs + ":" + mins + ":" + secs;
// }
// setInterval(displayTimes, 10);


// // for counter number

// const counters = document.querySelectorAll('.count');
// // Main function
// for (let n of counters) {
//     const updateCount = () => {
//         const target = +n.getAttribute('data-target');
//         const count = +n.innerText;
//         const speed = 1000; // change animation speed here
//         const inc = target / speed;
//         if (count < target) {
//             n.innerText = Math.ceil(count + inc);
//             setTimeout(updateCount, 1);
//         } else {
//             n.innerText = target;
//         }
//     }
//     updateCount();
// }



// circle prograss bar
</script>





@endsection