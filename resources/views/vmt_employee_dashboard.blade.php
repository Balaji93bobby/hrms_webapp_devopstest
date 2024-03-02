@extends('layouts.master')
@section('title')
@lang('translation.dashboards')
@endsection
@section('css')
<link href="{{ URL::asset('assets/css/hr_dashboard.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/holiday.css') }}">
<link rel="stylesheet" href="{{ URL::asset('/assets/css/calendar-vanila.css') }}">

<meta name="csrf-token" content="{{ csrf_token() }}" />

<!--Custom style.css-->
<!-- <link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/hr_dashboard.css') }}"> -->

<script src="{{ URL::asset('assets/js/calendar-vanila.js') }}" defer></script>
@endsection

@section('loading')
<section id="loading">
    <div class='face'>
        <div class='loader-container'>
            <img id="loader-image" src="{{ URL::asset('assets/images/abs logo.png') }}" />
            <span class='loading'></span>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="hr-dashboar-wrpper mt-30 ">
    <!-- Content top -->
    <div class="row">
        <div class="col-sm-6 col-md-6  col-xl-4 col-lg-4 col-xxl-4 mb-3">
            @include('ui-dashboard-welcome-card')
        </div>
        <div class="col-sm-6 col-md-6  col-xl-4 col-lg-4  d-flex col-xxl-4 mb-3">
            @include('ui-dashboard-action-card')
        </div>
        <div class="col-sm-6 col-md-6  col-xl-4 col-lg-4 d-flex col-xxl4 mb-3">
            @include('ui-dashboard-holiday-card')
        </div>
    </div>
    <!-- content middle -->

    <div class="row">
        <div class="col-sm-12 col-md-12 col-xl-8 col-lg-8 col-xxl-8">
            <div class="row mb-n4">
                <div class="col-sm-12 col-md-12 col-xl-12 col-lg-12 col-xxl-12">
                    <div class="card " style="height:200px;overflow-y:auto;">
                        <!-- <div class="p-1 bg-primary" ></div> -->
                        <div class="card-body ">
                            <div class="profile-wrapper d-flex p-0">
                                <div class="popover-body p-0 w-100">
                                    <div class="">
                                        <div>
                                            <ul class="nav sub-topnav">
                                                <!-- <li class="title active topbarNav fw-bold" id="post_view"><a>View
                                                                                                                    Post</a>
                                                                                                            </li> -->
                                                <li class="title  topbarNav fw-bold active" id="post">
                                                    <a>Post</a>
                                                </li>
                                                <li class="title topbarNav  fw-bold" id="announcement">
                                                    <a>Announcement</a>
                                                </li>
                                                <li class="title topbarNav fw-bold" id="poll"><a>Poll</a>
                                                </li>
                                                <li class="title topbarNav fw-bold" id="praise"><a>Praise</a>
                                                </li>
                                            </ul>
                                            <!-- code post view  -->


                                            <!-- emd view -->
                                            <div class="topbarContent emp-post">
                                                <div>
                                                    <div class="px-22 p-16 row no-gutters scrollBar">

                                                        <textarea name="post_menu" id="post_menu" class="border-0 outline-none w-100 h-100" placeholder="Write your Post here"></textarea>

                                                    </div>
                                                    <div class="post-contents d-flex align-items-center mx-4">

                                                        <div class="img-contents">
                                                            <i class="ri-image-2-fill"></i>
                                                            <input type="file" class="filestyle" name="image_src" id="image_src" data-input="false" multiple accept="image/*" data-iconName="fa fa-upload" data-buttonText="Upload File" />
                                                            <span class="tooltiptext">Image</span>

                                                        </div>

                                                        <div class="emoji-content mx-3">
                                                            <i class="ri-user-smile-line "></i>
                                                            <span class="tooltiptext">Emoji</span>

                                                        </div>


                                                    </div>
                                                    <button class="btn btn-primary  float-end" type="submit">
                                                        Create Post
                                                    </button>

                                                </div>
                                            </div>
                                            <div class="topbarContent emp-announcement " style="display:none;">
                                                <div class="scrollBar " >
                                                    @foreach($announcementData as $singleAnnouncement)
                                                        <div class="announcement-content scrollBar overflow-y" style="height: 100px">
                                                            <input class="form-control   w-100 h-100" value="{{ $singleAnnouncement->title_data }}" aria-label="default input example" placeholder="Title of the Announcement" type="text" id="title_data" name="title_data" readonly>
                                                            <input class="form-control   w-100 h-100" value="Date Posted : {{ \Carbon\Carbon::parse($singleAnnouncement->created_at)->format('M jS Y \\, h:i:s A') }}" aria-label="default input example" placeholder="Title of the Announcement" type="text" id="title_data" name="title_data" readonly>

                                                            <textarea class="form-control placeholder-glow w-100 h-100" style="text-align:left" placeholder="Details of Announcement"
                                                             aria-label="default input example" type="text" name="details_data"
                                                             id="details_data" readonly>{{ $singleAnnouncement->details_data }}</textarea>


                                                            <div class="bottom-content d-flex mx-2">

                                                                <div class="row">
                                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                                                        <div class="form-check ps-0">

                                                                            </label>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                                                        <div class="form-check ps-0">

                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6  col-xxl-6 ">
                                                                        <div class="form-check ps-0">

                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                                                        <div class="form-check ps-0">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="topbarContent emp-poll" style="display:none;">
                                                <div>
                                                    <div class="poll-content">
                                                        <form id="polling-questions-form-submit">
                                                            <input type="text" name="question" id="" class="form-control border-0 outline-none" placeholder="What this poll is about" required>
                                                            <hr>
                                                            <div class="content-container">
                                                                <div class="mt-3 d-flex align-items-center">
                                                                    <input type="text" name="options[]" id="" class="form-control " placeholder="Add option here" required>
                                                                </div>
                                                                <div class="mt-3 d-flex align-items-center">
                                                                    <input type="text" name="options[]" id="" class="form-control " placeholder="Add option here" required>
                                                                </div>
                                                            </div>
                                                            <div class="text-end my-2">
                                                                <!-- <button class="btn btn-secondary outline-none border-0"><i class=" ri-add-circle-line mr-2">Add More</i></button> -->
                                                                <button class="btn text-primary p-0 bg-transparent outline-none border-0 f-12 plus-sign" type="button"><i class="f-12 me-1 fa  fa-plus-circle" aria-hidden="true"></i>Add
                                                                    More</i></button>
                                                            </div>

                                                            <div class="bottom-content">
                                                                <div class="row">
                                                                    <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4 mt-1">
                                                                        <div class=" d-flex align-items-center">
                                                                            <label for="" class="me-1 mb-0">Poll
                                                                                Expires
                                                                                On</label>
                                                                            <input class=" me-1 anounce-date form-control" name="date" type="date" placeholder="Select date" id="" required style="background-color:#e9ecef">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4 mt-1">

                                                                        <input class="form-check-input check-box me-1" type="checkbox" name="notify_employees" id="notifyEmp2" value="1">
                                                                        <label class="form-check-label" for="notifyEmp2">
                                                                            Notify employees
                                                                        </label>

                                                                    </div>
                                                                    <div class="col-sm-6 col-md-6 col-xl-4 col-lg-4 mt-1">

                                                                        <input class="form-check-input check-box me-1" type="checkbox" name="anonymous_poll" value="1" id="anonymous">
                                                                        <label class="form-check-label" for="anonymous">
                                                                            Anonymous Poll
                                                                        </label>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mt-2 text-end">
                                                                <button class="btn btn-primary" id="polling-cancel-btn" type="button">Cancel</button>
                                                                <button class="btn btn-primary" id="polling-submit-btn" type="submit">Post</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="topbarContent emp-praise" style="display:none;">
                                                <div>
                                                    <form id="praise-form-submit">
                                                        <div>
                                                            <div class="px-20 p-16 row no-gutters scrollBar">
                                                                <textarea name="praise_data" id="" cols="30" rows="3" class="border-0 outline-none w-100" required></textarea>
                                                            </div>
                                                            <div class="text-end mt-2">
                                                                <button id="praise-submit-btn" type="submit" class="btn btn-primary py-1 px-4  float-right">
                                                                    Submit
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
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
        <!-- content bpttom -->
        <div class="col-sm-12 col-md-12 col-xl-4 col-lg-4 col-xxl-4 mb-3">
            <div class="calendar-wrapper card mb-0 border-0">
                <div class="card-body p-0">
                    <div class="_wrapper">
                        <div class="h-100  _container-calendar">
                            <div class="_button-container-calendar d-flex align-items-center justify-content-between">
                                <button id="_previous" onclick="previous()" class="previous"><i class="fa fa-chevron-left"></i></button>
                                <h6 id="_monthAndYear" class="_monthAndYear text-white"></h6>
                                <button id="_next" onclick="next()" class="next"><i class="fa fa-chevron-right"></i></button>
                            </div>
                            <table class="_table-calendar" id="_calendar" data-lang="en">


                                <thead id="_thead-month"></thead>
                                <tbody id="_calendar-body">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- content-bottom -->
    <div class="row">
        <div class="col-sm-12 col-md-12 col-xl-12 col-lg-12 col-xxl-12">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 ipad-query">
                    {{-- @foreach ($dashboardEmployeeEventsData['birthday'] as $key)
                            @include('ui-dashboard-event-card',['date' => $key->dob])
                    @endforeach --}}
                    @include('ui-dashboard-event-card', [
                    'dashboardEmployeeEventsData' => $dashboardEmployeeEventsData,
                    ])

                </div>
            </div>
        </div>


    </div>
</div>

<!--  -->
@endsection
@section('script')
<!-- Prem assets -->
<!-- OWL CAROUSEL -->

<!--Sweet alert JS-->

<script src="{{ URL::asset('/assets/premassets/js/progressbar.min.js') }}"></script>
<!--Nice select-->
<script src="{{ URL::asset('/assets/premassets/js/jquery.nice-select.min.js') }}"></script>

<!--Custom Js Script-->
<script src="{{ URL::asset('/assets/premassets/js/custom.js') }}"></script>
<script src="{{ URL::asset('/assets/premassets/js/holiday.js') }}"></script>
<script src="{{ URL::asset('/assets/premassets/js/calendar.min.js') }}"></script>
<script src="{{ URL::asset('/assets/premassets/js/calendar.js') }}"></script>

<!-- Prem assets ends -->

<!-- apexcharts -->
<!-- dashboard init -->
@yield('welcome-script')
@yield('script-profile-avatar')
<!-- for date and time -->


<script>
    $(document).ready(function() {

        $('body').on('click', '.plus-sign', function() {
            $('.content-container').append('<div class="mt-3 d-flex align-items-center"><input type="text" name="options[]"id="" class="form-control" placeholder="Add option here" required><i class="delete-row ri-delete-bin-7-fill mx-2 text-danger"></i></div>');
        });

        $('body').on('click', '.delete-row', function() {
            $(this).parent().remove();
        });

        $(function() {
            $("[data-toggle=popover]").popover({
                html: true,
                content: function() {
                    var content = $(this).attr("data-popover-content");
                    return $(content).children(".popover-body").html();
                },
            });
        });

        $('body').on('click', '.popover-close', function() {
            $("[data-toggle=popover]").popover('hide');
        });

        $('body').on('click', '.topbarNav', function() {
            $('.topbarNav').removeClass('active');
            $(this).addClass('active');
            var id = $(this).attr('id');
            $('.topbarContent').hide();
            $('.emp-' + id).css("display", "block");
        });

        // Announcement Submit Form through Ajax starts
        $('#announcement-form-submit').on('submit', function(e) {
            e.preventDefault();
            if ($('#announcement-form-submit').is(':valid')) {
                var announcementFormData = new FormData(document.getElementById("announcement-form-submit"));
                console.log(announcementFormData);

                $.ajax({
                    url: "{{ url('vmt-dashboard-announcement') }}",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: announcementFormData,
                    beforeSend: function() {
                        $("#annon_menu_submit").attr("disabled", true);
                    },
                    success: function(data) {
                        Swal.fire("Success!", "Announcement added successfully", "success");
                        document.getElementById("announcement-form-submit").reset();
                        $("#annon_menu_submit").attr("disabled", false);
                    }
                });

            }
        });
        // Announcement Submit Form through Ajax ends

        // Polling Submit Form through Ajax starts
        $('#polling-questions-form-submit').on('submit', function(e) {
            e.preventDefault();
            if ($('#polling-questions-form-submit').is(':valid')) {
                var pollingFormData = new FormData(document.getElementById("polling-questions-form-submit"));
                console.log(pollingFormData);

                $.ajax({
                    url: "{{ url('vmt-dashboard-polling-question') }}",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: pollingFormData,
                    beforeSend: function() {
                        $("#polling-submit-btn").attr("disabled", true);
                    },
                    success: function(data) {
                        if (data.status == true) {
                            Swal.fire("Success!", data.message, "success");
                            $('.delete-row').parent().remove();
                        } else {
                            Swal.fire("Error!", data.message, "error");
                        }
                        document.getElementById("polling-questions-form-submit").reset();
                        $("#polling-submit-btn").attr("disabled", false);
                    }
                });

            }
        });

        $('#polling-cancel-btn').on('click', function(e) {
            document.getElementById("polling-questions-form-submit").reset();
        });
        // Polling Submit Form through Ajax ends

        // Praise Submit Form through Ajax starts
        $('#praise-form-submit').on('submit', function(e) {
            e.preventDefault();
            if ($('#praise-form-submit').is(':valid')) {
                var praiseFormData = new FormData(document.getElementById("praise-form-submit"));
                console.log(praiseFormData);

                $.ajax({
                    url: "{{ url('vmt-dashboard-praise') }}",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: praiseFormData,
                    beforeSend: function() {
                        $("#praise-submit-btn").attr("disabled", true);
                    },
                    success: function(data) {
                        if (data.status == true) {
                            Swal.fire("Success!", data.message, "success");
                        } else {
                            Swal.fire("Error!", data.message, "error");
                        }
                        document.getElementById("praise-form-submit").reset();
                        $("#praise-submit-btn").attr("disabled", false);
                    }
                });

            }
        });
        // Praise Submit Form through Ajax Ends

        // $('#annon_menu_submit').click(function(e) {
        //     e.preventDefault();
        //     var image = $('#image_src').val();
        //     //alert(image);
        //     var title_data = $('#title_data').val();
        //     var details_data = $('#details_data').val();
        //     var user_ref_id = "{{ Auth::user()->id }}";
        //     $.ajax({
        //         type: "POST",
        //         url: "{{ url('vmt-dashboard-announcement') }}",
        //         data: {
        //             "_token": "{{ csrf_token() }}",
        //             title_data: title_data,
        //             user_ref_id: user_ref_id,
        //             details_data: details_data,
        //         },
        //         success: function(data) {
        //             // alert(data);
        //             location.reload();
        //         }
        //     })
        // });


        // for number increament

        $(function() {
            function count($this) {
                var current = parseInt($this.html(), 10);
                $this.html(++current);

                if (current != 0) {
                    if (current !== $this.data('count')) {
                        setTimeout(function() {
                            count($this)
                        }, 50);
                    }
                }
            }

            $(".number-increment").each(function() {
                var currentValue = parseInt($(this).html(), 10);
                $(this).data('count', currentValue);
                $(this).html('0');

                if (currentValue != 0)
                    count($(this));
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#submit_post_data').submit(function(e) {
            e.preventDefault();
            // alert("helooo");
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ url('vmt-dashboard-post') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    this.reset();
                    alert('Post Created Successfully');
                    console.log(data);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
    });
</script>
@endsection
