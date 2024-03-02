@extends('layouts.master')
@section('title')
@lang('translation.dashboards')
@endsection
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/gridjs/gridjs.min.css') }}">
    <link href="{{ URL::asset('assets/css/attendance.css') }}" rel="stylesheet">
@endsection
@section('content')
{{-- @component('components.attendance_breadcrumb')
@slot('li_1')@endslot
@endcomponent --}}
<div class="leavePolicy_config ">
    <div class="card ">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-6">
                    <h6 class="">Leave Settings</h6>
                </div>
                <div class="col-6 text-end">
                    <div class="d-flex justify-content-end">
                        <div class="input-group  w-50 me-2">
                            <label class="input-group-text " for="inputGroupSelect01"><i
                                    class="fa fa-calendar text-primary " aria-hidden="true"></i></label>
                            <select class="form-select btn-line-primary" id="inputGroupSelect01">
                                <option selected>FY 2022-23</option>

                            </select>
                        </div>
                        <div>
                            <button class="btn btn-orange" type="button">
                                New Policy
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card top-line">
                <div class="card-body">
                    <div class="row ">
                        <div class="col-10">
                            <h6 class="">Leave Policy Settings</h6>
                        </div>
                        {{-- <div class="col-2 text-end">
                            <div class="input-group  me-2">
                                <select class="form-select btn-line-primary" id="inputGroupSelect01">
                                    <option selected>FY 2022-23</option>
                                </select>
                            </div>
                        </div> --}}
                    </div>

                    <div id="leave-policy-table" class="leaveSettings_table"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="modal_edit_leave" class="modal custom-modal fade" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content profile-box">
                <div class="modal-header py-3 new-role-header d-flex align-items-center">
                    <h6 class="modal-title mb-1 text-primary" style="border-bottom:5px solid #d0d4e2;">
                    </h6>
                    <button type="button" class="close  border-0 h3" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="requires-validation" id="form_edit_leavepolicy" novalidate>
                        @csrf
                        <div class="row">
                            <input type="hidden" name="leave_policy_id" id='leave_policy_id'>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Annual (Days)</label>
                                    <input class="form-control" type="text" name="days_annual" id="days_annual"
                                        required>
                                    <div class="invalid-feedback">
                                        Please provide a valid text.
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Month (Days)</label>
                                    <input class="form-control" type="text" name="days_month" id="days_month"
                                        required>
                                    <div class="invalid-feedback">
                                        Please provide a valid text.
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Restricted Days</label>
                                    <input class="form-control" type="text" name="days_restricted"
                                        id="days_restricted" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid text.
                                    </div>

                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>Department</label>
                                <input class="form-control" type="text" name="department" id="department" required>
                                <div class="invalid-feedback">
                                    Please provide a valid text.
                                </div>

                            </div>
                        </div> --}}



                        </div>
                        <div class="submit-section">
                            <button type="button" id="submit_leaveedit"
                                class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <section class="leave-request-section">
        <div class="modal fade" id="requestmodal" tabindex="-1" aria-labelledby="requestmodalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="requestmodalLabel">Leave Request</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="border-top-blue">
                            <div class="row mb-2">
                                <div class="col-6 text-start">
                                    <p class="modal-sub-title">Leave Type</p>
                                </div>
                                <div class="col-6 text-end">
                                    <a class="btn btn-sm leave-policy" href="#">Leave Policy Explanation</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-md-6 mb-lg-4 mb-3">
                                    <div class="border-left-blue text-center">
                                        <h5>Casual Leave</h5>
                                        <span><span class="number-count-span">9</span>days</span>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis rerum velit
                                            possimus</p>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 mb-lg-4 mb-3">
                                    <div class="border-left-blue text-center">
                                        <h5>Sick Leave</h5>
                                        <span><span class="number-count-span">3</span>days</span>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis rerum velit
                                            possimus</p>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 mb-lg-4 mb-3">
                                    <div class="border-left-blue text-center">
                                        <h5>Earned Leave</h5>
                                        <span><span class="number-count-span">1</span>days</span>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis rerum velit
                                            possimus</p>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 mb-lg-0 mb-3">
                                    <div class="border-left-blue text-center">
                                        <h5>Maternity Leave</h5>
                                        <span><span class="number-count-span">180</span>days</span>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis rerum velit
                                            possimus</p>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 mb-lg-0 mb-3">
                                    <div class="border-left-blue text-center">
                                        <h5>Casual Leave</h5>
                                        <span><span class="number-count-span">3</span>days</span>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis rerum velit
                                            possimus</p>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 mb-lg-0 mb-3">
                                    <div class="border-left-blue text-center">
                                        <h5>Casual Leave</h5>
                                        <span><span class="number-count-span">6</span>days</span>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis rerum velit
                                            possimus</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-top-blue">
                            <div class="row">
                                <div class="col-xl-6">
                                    <p class="modal-sub-title">Set range</p>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-md-start mb-md-0 mb-3">
                                            <label>Start Date</label>
                                            <input type="date">
                                        </div>
                                        <div class="col-md-4 text-md-center mb-md-0 mb-3"
                                            style="display: flex;justify-content: center;align-items: center;">
                                            <span class="type-end-eight">Total days</span>
                                        </div>
                                        <div class="col-md-4 text-md-end">
                                            <label>End Date</label>
                                            <input type="date">
                                        </div>
                                    </div>
                                    <textarea class="w-100" rows="4"></textarea>
                                    <div class="py-2" style="border-bottom: 1px solid #cecece;"></div>
                                    <p class="modal-sub-title py-2">Notify to</p>
                                    <div class="row mb-3">
                                        <div class="col-md-4 mb-md-0 mb-3">
                                            <div class="profile-wrapper center">
                                                <div class="profile-body">
                                                    <img src="http://images.equipboard.com/uploads/user/image/524/big_calvin-harris.jpg?v=1466072866"
                                                        alt="" />
                                                    <div class="profile-details">
                                                        <p>Dillip Kumar</p>
                                                        <h5 class="description">Scottish DJ</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-md-0 mb-3">
                                            <div class="profile-wrapper center">
                                                <div class="profile-body">
                                                    <img src="http://images.equipboard.com/uploads/user/image/524/big_calvin-harris.jpg?v=1466072866"
                                                        alt="" />
                                                    <div class="profile-details">
                                                        <p>Dillip Kumar</p>
                                                        <h5 class="description">Scottish DJ</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-md-0 mb-3">
                                            <div class="profile-wrapper center">
                                                <div class="profile-body">
                                                    <img src="http://images.equipboard.com/uploads/user/image/524/big_calvin-harris.jpg?v=1466072866"
                                                        alt="" />
                                                    <div class="profile-details">
                                                        <p>Dillip Kumar</p>
                                                        <h5 class="description">Scottish DJ</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center text-md-end">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-orange">Request Leave</button>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="calendar">
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
    <div id="modal_edit_leave" class="modal custom-modal fade" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content profile-box">
                <div class="modal-header py-3 new-role-header d-flex align-items-center">
                    <h6 class="modal-title mb-1 text-primary" style="border-bottom:5px solid #d0d4e2;">
                    </h6>
                    <button type="button" class="close  border-0 h3" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="requires-validation" id="form_edit_leavepolicy" novalidate>
                        @csrf
                        <div class="row">
                            <input type="hidden" name="leave_policy_id" id='leave_policy_id'>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Annual (Days)</label>
                                    <input class="form-control" type="text" name="days_annual" id="days_annual" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid text.
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Month (Days)</label>
                                    <input class="form-control" type="text" name="days_month" id="days_month" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid text.
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Restricted Days</label>
                                    <input class="form-control" type="text" name="days_restricted" id="days_restricted" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid text.
                                    </div>

                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Department</label>
                                    <input class="form-control" type="text" name="department" id="department" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid text.
                                    </div>

                                </div>
                            </div> --}}



                        </div>
                        <div class="submit-section">
                            <button type="button" id="submit_leaveedit" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <section class="leave-request-section">
        <div class="modal fade" id="requestmodal" tabindex="-1" aria-labelledby="requestmodalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="requestmodalLabel">Leave Request</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="border-top-blue">
                            <div class="row mb-2">
                                <div class="col-6 text-start">
                                    <p class="modal-sub-title">Leave Type</p>
                                </div>
                                <div class="col-6 text-end">
                                    <a class="btn btn-sm leave-policy" href="#">Leave Policy Explanation</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-md-6 mb-lg-4 mb-3">
                                    <div class="border-left-blue text-center">
                                        <h5>Casual Leave</h5>
                                        <span><span class="number-count-span">9</span>days</span>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis rerum velit possimus</p>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 mb-lg-4 mb-3">
                                    <div class="border-left-blue text-center">
                                        <h5>Sick Leave</h5>
                                        <span><span class="number-count-span">3</span>days</span>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis rerum velit possimus</p>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 mb-lg-4 mb-3">
                                    <div class="border-left-blue text-center">
                                        <h5>Earned Leave</h5>
                                        <span><span class="number-count-span">1</span>days</span>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis rerum velit possimus</p>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 mb-lg-0 mb-3">
                                    <div class="border-left-blue text-center">
                                        <h5>Maternity Leave</h5>
                                        <span><span class="number-count-span">180</span>days</span>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis rerum velit possimus</p>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 mb-lg-0 mb-3">
                                    <div class="border-left-blue text-center">
                                        <h5>Casual Leave</h5>
                                        <span><span class="number-count-span">3</span>days</span>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis rerum velit possimus</p>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 mb-lg-0 mb-3">
                                    <div class="border-left-blue text-center">
                                        <h5>Casual Leave</h5>
                                        <span><span class="number-count-span">6</span>days</span>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis rerum velit possimus</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-top-blue">
                            <div class="row">
                                <div class="col-xl-6">
                                    <p class="modal-sub-title">Set range</p>
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-md-start mb-md-0 mb-3">
                                            <label>Start Date</label>
                                            <input type="date">
                                        </div>
                                        <div class="col-md-4 text-md-center mb-md-0 mb-3" style="display: flex;justify-content: center;align-items: center;">
                                            <span class="type-end-eight">Total days</span>
                                        </div>
                                        <div class="col-md-4 text-md-end">
                                            <label>End Date</label>
                                            <input type="date">
                                        </div>
                                    </div>
                                    <textarea class="w-100" rows="4"></textarea>
                                    <div class="py-2" style="border-bottom: 1px solid #cecece;"></div>
                                    <p class="modal-sub-title py-2">Notify to</p>
                                    <div class="row mb-3">
                                        <div class="col-md-4 mb-md-0 mb-3">
                                            <div class="profile-wrapper center">
                                                <div class="profile-body">
                                                    <img src="http://images.equipboard.com/uploads/user/image/524/big_calvin-harris.jpg?v=1466072866" alt="" />
                                                    <div class="profile-details">
                                                        <p>Dillip Kumar</p>
                                                        <h5 class="description">Scottish DJ</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-md-0 mb-3">
                                            <div class="profile-wrapper center">
                                                <div class="profile-body">
                                                    <img src="http://images.equipboard.com/uploads/user/image/524/big_calvin-harris.jpg?v=1466072866" alt="" />
                                                    <div class="profile-details">
                                                        <p>Dillip Kumar</p>
                                                        <h5 class="description">Scottish DJ</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-md-0 mb-3">
                                            <div class="profile-wrapper center">
                                                <div class="profile-body">
                                                    <img src="http://images.equipboard.com/uploads/user/image/524/big_calvin-harris.jpg?v=1466072866" alt="" />
                                                    <div class="profile-details">
                                                        <p>Dillip Kumar</p>
                                                        <h5 class="description">Scottish DJ</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center text-md-end">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-orange">Request Leave</button>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="calendar">
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
<script src="{{ URL::asset('assets/libs/gridjs/gridjs.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/pages/dashboard-projects.init.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

<script>
    var gridtable_leavePolicy = "";

    $(document).ready(function() {
        if (document.getElementById("leave-policy-table")) {
            gridtable_leavePolicy = new gridjs.Grid({
                columns: [
                    {
                        id: 'leave_type',
                        name: 'Leave Type',
                    },
                    {
                        id: 'days_annual',
                        name: 'Annual(Days)',
                    },
                    {
                        id: 'days_monthly',
                        name: 'Month(Days)',
                    },
                    {
                        id: 'days_restricted',
                        name: 'Restricted Days',
                    },
                    {
                        id: 'leave_policy',
                        name: 'Department',
                    },
                    {
                        id: 'id',
                        name: 'Action',
                        formatter: function formatter(cell) {

                            htmlcontent = '<input type="button" value="Edit" onclick="EditLeaveData(this)" data-policydbid="'+cell+'" class="btn_edit_leave btn btn-orange py-1 " data-bs-target="" data-bs-toggle="modal"></input>';
                            return gridjs.html(htmlcontent);
                        }
                    },
                ],
                pagination: {
                    limit: 10
                },
                sort: true,
                search: true,
                server: {
                    url: '{{route('vmt-fetch-leave-policy-details')}}',
                    then: data => data.map(
                        leave_policy => [
                            leave_policy.leave_type,
                            leave_policy.days_annual,
                            leave_policy.days_monthly,
                            leave_policy.days_restricted,
                            leave_policy,
                            leave_policy.id
                        ]
                    )
                },
            }).render(document.getElementById("leave-policy-table"));
        }

        $('#submit_leaveedit').click(function() {
            var form_data1 = new FormData(document.getElementById("form_edit_leavepolicy"));
            $.ajax({
                url: "{{route('set-singleleavepolicy-record')}}",
                type: "POST",
                dataType: "json",
                data: form_data1,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data+'success');
                    if (data == "200") {
                        //var rowId = $('#row_id').val() - 1;
                        // var row = $("table tbody tr:eq(" + rowId + ")");
                        // row.find("td:eq(0)").html('<b>'+$("#asset_name").val()+'</b>');
                        // row.find("td:eq(1)").html($("#asset_type").val());
                        // row.find("td:eq(2)").html($("#serial_number").val());
                        // row.find("td:eq(3)").html($("#warranty").val());
                        // row.find("td:eq(4)").html($("#vendor").val());
                        // row.find("td:eq(5)").html($("#assignee").val());
                        // row.find("td:eq(6)").html($("#assigned_date").val());

                    }
                    $('#modal_edit_leave').modal('hide');
                    window.location.reload();

                    /*gridtable_leavePolicy.updateConfig({

                    }).forceRender();*/
                },
                error: function(data) {
                    console.log(data+'error');
                }
            });
        });

    });



    function EditLeaveData(element) {
        // console.log(column_name+" , "+ row_id);
            var policydbid = $(element).attr('data-policydbid');
            console.log("Editing leave row : "+policydbid);

            $.ajax({
                url: "{{route('get-singleleavepolicy-record','')}}"+"/"+policydbid,
                type: "GET",
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log("Editing Leave type : "+data.leave_type);
                    $('#leave_policy_id').val(data.id);
                    $('#days_annual').val(data.days_annual);
                    $('#days_month').val(data.days_monthly);
                    $('#days_restricted').val(data.days_restricted);
                    //$('#department').val(data[4]['data']);
                    $('#modal_edit_leave').modal('show');

                   // $('#modal_edit_asset').modal('hide');
                },
                error: function(data) {
                    console.log(data+'error');
                }
            });


        }
</script>
@endsection
