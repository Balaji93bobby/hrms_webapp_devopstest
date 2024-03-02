@extends('layouts.master')
@section('css')

<link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">

<!-- for styling -->
<link href="{{ URL::asset('assets/css/appraisal_review.css') }}" rel="stylesheet">

@endsection
@section('content')
@component('components.performance_breadcrumb')
@slot('li_1')
@endslot
@endcomponent


<div>
    <div class="card  profile-box card-top-border ">
        <div class="card-body">

            <div class="row">

                <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12">
                    <div class="card  appraisal-right-content">
                        <div class="card-body">

                            <div class="mb-3 input-wrap">
                                <p>Overall Annual Score</p>
                                <div class="appraisal-box  btn bg-success text-white ">
                                    @if($ratingDetail)
                                    {{ round($ratingDetail['rating']) }}
                                    @else - @endif</div>

                            </div>
                            <div class="mb-3 input-wrap">
                                <p>Corresponding ANNUAL PERFORMANCE Rating</p>
                                <div class="appraisal-box  btn bg-success  text-white">
                                    @if($ratingDetail){{$ratingDetail['performance']}}@else - @endif</div>
                            </div>
                            <div class="mb-3 input-wrap">
                                <p>Ranking</p>
                                <div class="appraisal-box   btn bg-success text-white ">
                                    @if($ratingDetail){{$ratingDetail['ranking']}}@else - @endif</div>
                            </div>
                            <div class=" input-wrap">
                                <p>Action</p>
                                <div class="appraisal-box btn bg-danger text-white">
                                    @if($ratingDetail){{$ratingDetail['action']}}@else - @endif</div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>



<div class="row">
    <div class="col-xl-12">
        <div class="card">

        </div>

        <!-- <div class="card">

            <table class="table e-table align-middle table-nowrap mb-0 " style="border: none;">

                <tbody>
                    <tr style="border: none;">
                        <td class=" text-left">
                            <b>Overall Annual Score: </b>
                        </td>
                        <td class="text-left">
                            @if($ratingDetail){{$ratingDetail['rating']}}@else - @endif
                        </td>
                    </tr>
                    <tr style="border: none;">
                        <td class="text-left">
                            <b>Corresponding ANNUAL PERFORMANCE Rating:</b>
                        </td>
                        <td class="text-left">
                            @if($ratingDetail){{$ratingDetail['performance']}}@else - @endif
                        </td>
                    </tr>
                    <tr style="border: none;">
                        <td class="col-xl-6 text-left">
                            <b>Ranking:</b>
                        </td>
                        <td class="col-xl-6 text-left">
                            @if($ratingDetail){{$ratingDetail['ranking']}}@else - @endif
                        </td>
                    </tr>
                    <tr style="border: none;">
                        <td class="col-xl-6 text-left">
                            <b> Action:</b>
                        </td>
                        <td class="col-xl-6 text-left">
                            @if($ratingDetail){{$ratingDetail['action']}}@else - @endif
                        </td>
                    </tr>
                </tbody>
            </table>

        </div> -->

        <!-- @can('L1_Review')
                            <th style=" background-color: #405189;">
                                <h6 style="color:white;">Reporting Manger Review's (L1)<br /><br /> Comments
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Score
                                </h6>
                            </th>
                            @endcan

                            @can('L2_Review')
                            <th class="r" style=" background-color: #405189;">
                                <h6 style="color:white;"> Managers Manager (L2)<br /><br /> Comments
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Score</h6>
                            </th>
                            @endcan

                            @can('Final_Review')
                            <th class="r" style=" background-color: #405189;">
                                <h6 style="color:white;"> Final Review <br />( HR or Head Of the Department)</h6>
                            </th>
                            @endcan -->


        <!-- appraisal table -->
        <div class="card mb-0">
            <div class="card-body pb-2">
                <div class="row">
                    <div class="col-12 mt-3">
                        <form id="upload_form" enctype="multipart/form-data">
                            <div class="row pull-right mb-3">
                                @csrf
                                <div class="col">
                                    <a href="{{route('download-file', $kpiRowsId)}}" class="btn btn-primary pull-right" id="download-excel">Download</a>
                                </div>
                                <div class="col-auto p-0">
                                    <input type="file" name="upload_file" id="upload_file" accept=".xls,.xlsx" class="form-control" required>
                                </div>
                                <div class="col">
                                    <button type="button" class="btn btn-primary pull-right" id="upload-goal" disabled>Upload</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @if(count($kpiRows) > 0)
                <form id="employee_self_review" method="POST">
                    @csrf
                    <input type="hidden" name="goal_id" value="{{$assignedGoals->id}}">
                    <div class="table-content mb-4">
                        <div class="table-responsive">
                            <table id='table' class="table align-middle mb-0 table-bordered" data-paging="true" data-paging-size="10" data-paging-limit="3" data-paging-container="#paging-ui-container" data-paging-count-format="{PF} to {PL}" data-sorting="true" data-filtering="false" data-empty="No Results" data-filter-container="#filter-form-container" data-editing-add-text="Add New">
                                <thead class="thead" id="tHead">
                                    <tr>
                                        <th scope="col" data-name='dimension' data-filterable="false" data-visible="true">Dimension</th>
                                        <th scope="col" data-name='kpi' data-filterable="false" data-visible="true">KPI</th>
                                        <th scope="col" data-name='operational' data-filterable="false" data-visible="true">Operational Definition</th>
                                        <th scope="col" data-name='measure' data-filterable="false" data-visible="true">Measure</th>
                                        <th scope="col" data-name='frequency' data-filterable="false" data-visible="true">Frequency</th>
                                        <th scope="col" data-name='target' data-filterable="false" data-visible="true">Target</th>
                                        <th scope="col" data-name='stretchTarget' data-filterable="false" data-visible="true">Stretch Target</th>
                                        <th scope="col" data-name='source' data-filterable="false" data-visible="true">Source</th>
                                        <th scope="col" data-name='kpiWeightage' data-filterable="false" data-visible="true">KPI Weightage</th>
                                        <th scope="col" data-name='kpiSelfReview' data-filterable="false" data-visible="true">KPI - Achievement (Self Review)</th>
                                        <th scope="col" data-name='kpiSelfAchivement' data-filterable="false" data-visible="true">Self KPI Achievement %</th>
                                        <th scope="col" data-name='comments' data-filterable="false" data-visible="true">Comments</th>
                                        @if($reviewCompleted)
                                        <th scope="col" data-name='kpiManagerReview' data-filterable="false" data-visible="true">KPI - Achievement (Manager Review)</th>
                                        <th scope="col" data-name='kpiManagerAchivement' data-filterable="false" data-visible="true">Manager KPI Achievement %</th>
                                        <th scope="col" data-name='kpiHrReview' data-filterable="false" data-visible="true">KPI - Achievement (HR Review)</th>
                                        <th scope="col" data-name='kpiHrAchivement' data-filterable="false" data-visible="true">HR KPI Achievement %
                                        </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="tbody" id="tbody">
                                    @foreach($kpiRows as $index => $kpiRow)
                                    <tr>
                                        <th scope="row">{{$kpiRow->dimension}}</th>
                                        <td width="10%">
                                            <div>{{$kpiRow->kpi}}</div>
                                        </td>
                                        <td>
                                            <div> {{$kpiRow->operational_definition}} </div>
                                        </td>
                                        <td>
                                            <div>{{$kpiRow->measure}} </div>
                                        </td>
                                        <td>
                                            <div> {{$kpiRow->frequency}}</div>
                                        </td>
                                        <td>
                                            <div>{{$kpiRow->target}}</div>
                                        </td>
                                        <td>
                                            <div>{{$kpiRow->stretch_target}}</div>
                                        </td>
                                        <td>
                                            <div>{{$kpiRow->source}}</div>
                                        </td>
                                        <td>
                                            <div>{{$kpiRow->kpi_weightage}}</div>
                                        </td>
                                        <td>
                                            @if($assignedGoals->is_employee_submitted)
                                            {{$kpiRow->self_kpi_review}}
                                            @else
                                            <div>
                                                @if($assignedGoals->is_manager_approved &&
                                                !$assignedGoals->is_employee_submitted)
                                                <textarea name="selfreview[{{$kpiRow->id}}]" id="selfreview{{$index}}" cols="40" rows="8" placeholder="type here">@if(isset($kpiRow->self_kpi_review)) {{$kpiRow->self_kpi_review}} @endif</textarea>
                                                @endif
                                            </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($assignedGoals->is_employee_submitted)
                                            {{round($kpiRow->self_kpi_percentage)}}%
                                            @else
                                            <div>
                                                @if($assignedGoals->is_manager_approved &&
                                                !$assignedGoals->is_employee_submitted)
                                                <!-- <textarea name="selfkpiachievement[{{$kpiRow->id}}]" id="" cols="40" rows="8"
                                                placeholder="type here">@if(isset($kpiRow->self_kpi_percentage)) {{ round($kpiRow->self_kpi_percentage)}} @endif</textarea> -->
                                                <input type="number" class="inp-text" id="selfkpiachievement{{$index}}" name="selfkpiachievement[{{$kpiRow->id}}]" placeholder="type here" value="@if(isset( $kpiRow->self_kpi_percentage)) {{ round($kpiRow->self_kpi_percentage)}}@endif">
                                                @endif
                                            </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($assignedGoals->is_employee_submitted)
                                            {{$kpiRow->self_kpi_comments}}
                                            @else
                                            <div>
                                                @if($assignedGoals->is_manager_approved &&
                                                !$assignedGoals->is_employee_submitted)
                                                <textarea name="selfcomments[{{$kpiRow->id}}]" id="selfcomments{{$index}}" cols="40" rows="8" placeholder="type here"> @if(isset($kpiRow->self_kpi_comments)) {{$kpiRow->self_kpi_comments}} @endif</textarea>
                                                @endif
                                            </div>
                                            @endif
                                        </td>
                                        @if($reviewCompleted)

                                        <td>
                                            {{$kpiRow->manager_kpi_review}}
                                        </td>
                                        <td>
                                            {{$kpiRow->manager_kpi_percentage}}%
                                        </td>
                                        <td>
                                            {{$kpiRow->hr_kpi_review}}
                                        </td>
                                        <td>
                                            {{$kpiRow->hr_kpi_percentage}}%

                                        </td>
                                        @endif

                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            <div class="table-responsive"></div>

                        </div>
                </form>
                <div class="buttons d-flex align-items-center justify-content-end ">
                    @if(!$assignedGoals->is_employee_accepted)
                    <button class="btn btn-primary" id="approve">Accept<i class="fa fa-save"></i></button>
                    &nbsp;&nbsp;
                    <button class="btn btn-primary" id="reject">Reject<i class="fa fa-save"></i></button>
                    &nbsp;&nbsp;
                    @else
                    @if(!$reviewCompleted && !$assignedGoals->is_employee_submitted &&
                    $assignedGoals->is_manager_approved )
                    <button class="btn btn-primary" id="save_table">Save<i class="fa fa-save"></i></button>
                    &nbsp;&nbsp;
                    <button class="btn btn-primary" id="publish_table">Submit<i class="fa fa-save"></i></button>
                    @endif

                    @endif
                </div>
                @endif

            </div>
        </div>
    </div><!-- end col -->

    @if($reviewCompleted)

    <div class="row mt-3">
        <div class="col-lg-12">
            <h6 class="text-muted">
                Appraiser Feedback:
            </h6>
            <div class="mt-2">
                <textarea class="form-control outline-none " placeholder="" id="gen-info-description-input" name="performance" rows="4" readonly>@if(isset( $assignedGoals->appraiser_comment)){{$assignedGoals->appraiser_comment}}@endif</textarea>
            </div>
        </div>
    </div>
    @endif


    @if($reviewCompleted)
    <div class="row mt-3">
        <div class="col-lg-12">
    <div class="card mt-3">
        <div class="card-header">
            <h5>Best People Rating Grid</h5>
        </div>
        <div class="card-body pb-2">
            <h6>Appraisee's Annual Score & Rating</h6>
            <div class="table-content mb-1">
                <table class="table rating_table align-middle mb-0 table-bordered  " id="table">

                    <thead class="thead" id="tHead">
                        <tr>
                            <th scope="col">Overall Annual Score</th>
                            <th scope="col">Less than 60</th>
                            <th scope="col">61-70</th>
                            <th scope="col">71-80</th>
                            <th scope="col">81-90</th>
                            <th scope="col">91-100</th>
                        </tr>
                    </thead>
                    <tbody class="tbody" id="tbody">
                        <tr>

                            <td class="">
                                Corresponding ANNUAL PERFORMANCE Rating

                            </td>
                            <td class="">Needs Action</td>
                            <td class="">Below Expectations</td>
                            <td class="">Meet Expectations</td>
                            <td class="">Exceeds Expectations </td>
                            <td class="">Exceptionally Exceeds Expectations</td>
                        </tr>

                        <tr>
                            <td class="">
                                Ranking
                            </td>
                            <td class="">1</td>
                            <td class="">2</td>
                            <td class="">3</td>
                            <td class="">4</td>
                            <td class="">5</td>
                        </tr>
                        <tr>

                            <td class="">
                                Action
                            </td>
                            <td class="">Exit</td>
                            <td class="">PIP</td>
                            <td class="">10%</td>
                            <td class="">15%</td>
                            <td class="">20%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
    @endif

    <!-- Modal -->
    <div class="modal fade flip" id="acceptPMS" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-5 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                    <div class="mt-4 text-center">
                        <h4>You are about to delete a order ?</h4>

                        <p class="text-muted fs-15 mb-4">Deleting your order will remove
                            all of
                            your information from our database.</p>
                        <div class="hstack gap-2 justify-content-center remove">
                            <button class="btn btn-link link-success fw-medium text-decoration-none" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                Close</button>
                            <button class="btn btn-danger" id="delete-record">Yes,
                                Delete It</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end modal -->



</div><!-- end row -->

<div class="modal fade" id="notificationModal" role="dialog" aria-hidden="true" style="opacity:1; display:none;background:#00000073;">
    <div class="modal-dialog modal-md modal-dialog-centered" id="" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2">
        <div class="modal-content">
            <div class="modal-header py-2 bg-primary">

                <div class="w-100 modal-header-content d-flex align-items-center py-2">
                    <h5 class="modal-title text-white" id="modalHeader">Rejected
                    </h5>
                    <button type="button" class="btn-close btn-close-white close-modal" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="mt-4">
                    <h5 class="mb-3" id="modalNot"></h5>
                    <textarea name="reject_content" id="reject_content" class="form-control mb-3"></textarea>
                    <div class="hstack gap-2 justify-content-center">
                        <button type="button" class="btn btn-primary" id="reject_save" disabled>Save</button>
                        <button type="button" class="btn btn-light close-modal" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<!-- apexcharts -->


<script src="{{ URL::asset('/assets/premassets/js/footable.min.js') }}"></script>
<script src="{{ URL::asset('/assets/premassets/css/footable.bootstrap.min.css') }}"></script>
<script type="text/javascript">
    //$('#prizePopup').modal('show');
    /* var showPopup = "{{$showModal}}";
     if(showPopup){
         console.log('accept-goals');

         $('#acceptPMS').modal('show');
     }*/
    $('#upload_file').change(function() {
        if ($(this).is(':valid')) {
            $('#upload-goal').removeAttr('disabled');
        } else {
            $('#upload-goal').attr('disabled', true);
        }
    });

    $('#upload-goal').click(function() {
        var form_data = new FormData(document.getElementById("upload_form"));
        $.ajax({
            type: "POST",
            url: "{{route('upload-file-review')}}",
            dataType: "json",
            contentType: false,
            processData: false,
            data: form_data,
            success: function(data) {
                // $('.addition-content').html('');
                $.each(data[0], function(key, value) {
                    $('#selfreview' + key).val(value[9]);
                    $('#selfkpiachievement' + key).val(value[10]);
                    $('#selfcomments' + key).val(value[11]);
                });
            }
        });
    });

    $('#save_table').click(function(e) {
        e.preventDefault();
        console.log("save trigger");
        console.log($('#employee_self_review').serialize());

        $.ajax({
            type: "POST",
            url: "{{url('vmt-pms-saveKPItableDraft_Employee')}}",
            data: $('#employee_self_review').serialize(),
            success: function(data) {
                alert(data);
            }
        })
    });

    ft = FooTable.init('#kpiTable', {});

    $('#publish_table').click(function(e) {
        e.preventDefault();
        console.log("save trigger");
        console.log($('#employee_self_review').serialize());

        $.ajax({
            type: "POST",
            url: "{{url('vmt-pmsappraisal-review')}}",
            data: $('#employee_self_review').serialize(),
            success: function(data) {
                alert(data);
                window.location.reload();
            }
        })
    });

    $('#approve').click(function(e) {
        e.preventDefault();
        //goal_id=26&user_id=4
        var goal_id = "{{\Request::get('id')}}";
        var user_id = "{{Auth::user()->id}}";
        var approve_flag = "approved";

        $.ajax({
            type: "GET",
            url: "{{url('vmt-approvereject-kpitable')}}?goal_id=" + goal_id + "&user_id=" + user_id +
                "&approve_flag=" + approve_flag,
            success: function(data) {
                alert(data);
                location.reload();
            }
        })
    });

    $('body').on("keyup", '#reject_content', function() {
        if ($(this).val() == '') {
            $('#reject_save').attr('disabled', true);
        } else {
            $('#reject_save').removeAttr('disabled');
        }
    });

    $('#reject_save').click(function(e) {
        e.preventDefault();
        var goal_id = "{{\Request::get('id')}}";
        var user_id = "{{auth::user()->id}}";
        var approve_flag = "rejected";
        var content = $('#reject_content').val();

        $.ajax({
            type: "POST",
            url: "{{url('vmt-approvereject-command')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                content: content,
                goal_id: goal_id,
                user_id: user_id,
            },
            success: function(data) {
                e.preventDefault();
                var goal_id = "{{\Request::get('id')}}";
                var user_id = "{{auth::user()->id}}";
                var approve_flag = "rejected";
                var command = $('#reject_content').val();
                $.ajax({
                    type: "GET",
                    url: "{{url('vmt-approvereject-kpitable')}}?goal_id=" + goal_id +
                        "&user_id=" + user_id + "&approve_flag=" + approve_flag + "&command=" +
                        command,
                    success: function(data) {
                        $('#notificationModal').hide();
                        $('#notificationModal').addClass('fade');
                        window.location.reload();
                    }
                });
            }
        })
    });


    $('#reject').click(function(e) {
        e.preventDefault();
        $('#modalHeader').html("Rejected");
        $('#modalNot').html(
            "Are you sure you want to reject this Kpi. If yes, please entered the reason in the below command box:"
        );
        $('#notificationModal').show();
        $('#notificationModal').removeClass('fade');
    });


    $('body').on('click', '.close-modal', function() {
        $('#notificationModal').hide();
        $('#notificationModal').addClass('fade');
        window.location.reload();
    });
</script>
@endsection
