@extends('layouts.master')
@section('title')
    @lang('translation.dashboards')
@endsection
@section('content')
    <div class="createNew_policy-wrapper mt-30">

        <div class="card ">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-3 ">
                        <h6 class="modal-title">Create New Leave Policy</h6>
                    </div>
                    <div class="col-12 mb-3 ">
                        <div class="showPolicy-table" id="showPolicy-table">
                            <div class="col-md-4 mx-auto text-center no-data-img">
                                <img src="{{ URL::asset('assets/images/no_dataFile.svg') }}" class="h-100 w-100"
                                    alt="no-data">
                                <h5 class="text-muted">Create Policy </h5>
                            </div>
                        </div>

                    </div>
                    <div class="text-right col-12">
                        <button class="btn btn-border-orange policy_tablerow" id="policy_tablerow" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#addPolicy_form" style="display: none">
                            <i class="fa fa-plus-circle me-1"></i> Create
                        </button>
                    </div>


                    <div class="col-12 text-center">
                        {{--
                        <button class="btn btn-border-orange" id="createPolicy_table" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#addPolicy_form">
                            <i class="fa fa-plus-circle me-1"></i> Create
                        </button> --}}
                        <button class="btn btn-border-orange" id="createPolicy_table" type="button">
                            <i class="fa fa-plus-circle me-1"></i> Create
                        </button>


                    </div>
                </div>
            </div>
        </div>

        <div class="offcanvas offcanvas-end " tabindex="-1" id="addPolicy_form" aria-labelledby="">
            <div class="offcanvas-header">
                <h6 id="" class="modal-title">Add New Policy </h6>
                <button type="button" class="close close-pop outline-none bg-transparent border-0 h3 "
                    data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <form name="leavePolicyForm" id="">
                    <div class="mb-2 form-group">
                        <label for="" class="float-label">Leave Type<span class="text-danger">*</span> </label>
                        <select placeholder="" name="leaveType" id="leave_type" class=" form-select form-control ">
                            <option value="">Choose Leave Type</option>
                            <option value="Sick">Sick Leave</option>
                            <option value="Casual">Casual Leave</option>
                            <option value="Maternity">Maternity Leave</option>
                            <option value="Paternity">Paternity Leave</option>
                            <option value="Earned">Earned Leave</option>
                        </select>
                        <span class="errorMsg  text-danger"></span>
                    </div>


                    <div class="mb-2 form-group">
                        <label for="" class="float-label">Annual (Days)<span class="text-danger">*</span></label>
                        <input type="text" maxlength="2 " minlength="2" placeholder="Type Annual" name="annualDays"
                            id="annual_days" class=" form-control  " />
                        <span class="errorMsg f-12 annual-error  text-danger"></span>
                    </div>

                    <div class="mb-2 form-group">
                        <label for="" class="float-label">Month (Days)<span class="text-danger">*</span></label>
                        <input type="text" maxlength="2 " minlength="2" placeholder="Type Month" name="monthDays"
                            id="month_days" class="form-control  " />
                        <span class="errorMsg f-12 month-error text-danger"></span>
                    </div>

                    <div class="mb-2 form-group">
                        <label for="" class="float-label">Restricted (Days)<span
                                class="text-danger">*</span></label>
                        <input type="text" maxlength="2 " minlength="2" placeholder="Type Restricted"
                            name="restrictedDays" id="restricted_days" class=" form-control  " />
                        <span class="errorMsg f-12 restrict-error text-danger"></span>
                    </div>
                    <div class="mb-2 form-group">
                        <label for="" class="float-label">Accural (Days)<span class="text-danger">*</span></label>
                        <input type="text" maxlength="2 " minlength="2" placeholder="Type Accural" name="accuralDays"
                            id="accural_days" class=" form-control  " />
                        <span class="errorMsg f-12 accural-error text-danger"></span>
                    </div>
                    <div class="mb-4 form-group">
                        <label for="" class="float-label">Notes<span class="text-danger">*</span></label>
                        <textarea name="leaveNotes" id="instructions_notes" placeholder="Type Notes" class="resize-none form-control"
                            rows="3"></textarea>
                        <span class="errorMsg text-danger"></span>
                    </div>
                    <div class=" text-end">
                        <input class="btn btn-border-orange saveNew-policy" id="saveNew_policy" type="submit">
                    </div>
                </form>
            </div>
        </div>


    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // pattern matching
            var numRegex = new RegExp('^[0-9]$');
            let classes = (classes) => document.getElementsByClassName(errorMsg);

            // console.log(leaveType);
            // errorMsg=errorMsg(errors);

            function clearValidations() {
                $('#leave_type').removeClass('is-valid');
                $('#annual_days ').removeClass('is-valid');
                $('#month_days ').removeClass('is-valid');
                $('#restricted_days').removeClass('is-valid');
                $('#accural_days').removeClass('is-valid');
                $('#instructions_notes').removeClass('is-valid');

                $('#leave_type').removeClass('is-invalid');
                $('#annual_days ').removeClass('is-invalid');
                $('#month_days ').removeClass('is-invalid');
                $('#restricted_days').removeClass('is-invalid');
                $('#accural_days').removeClass('is-invalid');
                $('#instructions_notes').removeClass('is-invalid');

            }

            function clearValue() {
                $('#leave_type').val('');
                $('#annual_days ').val('');
                $('#month_days ').val('');
                $('#restricted_days').val('');
                $('#accural_days').val('');
                $('#instructions_notes').val('');

            }


            // create table
            $('#createPolicy_table').click(function() {

                $('.no-data-img').css('display', 'none');
                var createPolicyTable =
                    '<table id="policyTable" class="table table-hover table-bordered">';
                createPolicyTable +=
                    '<thead><tr><th colspan="2">Leave Type</th><th  colspan="2">Annual (Days)</th><th  colspan="2">Month (Days)</th><th  colspan="2">Restricted (Days)</th><th  colspan="2">Accural (Days)</th></tr></thead><tbody></tbody>';
                createPolicyTable += '</table>';

                $("#showPolicy-table").append(createPolicyTable);

                $('#createPolicy_table').css('display', 'none');
                $('.policy_tablerow').css('display', 'revert');

            });


            $('#annual_days').keypress(function(e) {
                var annualKeyCode = e.keyCode || e.which;
                var annual_isValid = numRegex.test(String.fromCharCode(annualKeyCode));
                if (!annual_isValid) {
                    $('#annual_days').addClass('is-invalid');

                    $('.annual-error').text('Should be a number *');
                } else {
                    $('#annual_days').removeClass('is-invalid');
                    $('#annual_days').addClass('is-valid');
                    $('.annual-error').text('');
                }
                return annual_isValid;
            });
            $('#month_days').keypress(function(e) {
                var annualKeyCode = e.keyCode || e.which;
                var annual_isValid = numRegex.test(String.fromCharCode(annualKeyCode));
                if (!annual_isValid) {
                    $('#month_days').addClass('is-invalid');
                    $('.month-error').text('Should be a number *');

                } else {
                    $('#month_days').removeClass('is-invalid');
                    $('#month_days').addClass('is-valid');
                    $('.month-error').text('');
                }
                return annual_isValid;
            });
            $('#restricted_days').keypress(function(e) {
                var annualKeyCode = e.keyCode || e.which;
                var annual_isValid = numRegex.test(String.fromCharCode(annualKeyCode));
                if (!annual_isValid) {
                    $('#restricted_days').addClass('is-invalid');
                    $('.restrict-error').text('Should be a number *');

                } else {
                    $('#restricted_days').removeClass('is-invalid');
                    $('#restricted_days').addClass('is-valid');
                    $('.restrict-error').text('');
                }
                return annual_isValid;
            });

            $('#accural_days').keypress(function(e) {
                var accuralKeyCode = e.keyCode || e.which;
                var annual_isValid = numRegex.test(String.fromCharCode(accuralKeyCode));
                if (!annual_isValid) {
                    $('#accural_days').addClass('is-invalid');
                    $('.accural-error').text('Should be a number *');
                } else {
                    $('#accural_days').removeClass('is-invalid');
                    $('#accural_days').addClass('is-valid');
                    $('.accural-error').text('');
                }
                return annual_isValid;
            });
            $('#instructions_notes').keypress(function(e) {
                // var accuralKeyCode = e.keyCode || e.which;
                // var annual_isValid = numRegex.test(String.fromCharCode(accuralKeyCode));
                var instructNotes = this;
                console
                if (instructNotes != '') {
                    $('#instructions_notes').addClass('is-valid');

                } else {
                    $('#instructions_notes').removeClass('is-valid');
                    $('#instructions_notes').addClass('is-invalid');
                }
                return instructNotes;
            });


            $('#saveNew_policy').click(function(e) {
                e.preventDefault();
                var leaveType = $('#leave_type').val(),
                    annualDays = $('#annual_days ').val(),
                    monthDays = $('#month_days ').val(),
                    restrictedDays = $('#restricted_days').val(),
                    accuralDays = $('#accural_days').val(),
                    leaveNotes = $('#instructions_notes').val();


                var isValid = true;

                if (isValid) {
                    if ($('#leave_type').val().trim() == '') {
                        $('#leave_type').addClass('is-invalid');
                        isValid = false;
                    } else {
                        $('#leave_type').removeClass('is-invalid');
                        $('#leave_type').addClass('is-valid');

                    }
                    if ($('#annual_days').val().trim() == '') {
                        $('#annual_days').addClass('is-invalid');
                        isValid = false;
                    } else {
                        $('#annual_days').removeClass('is-invalid');
                        $('#annual_days').addClass('is-valid');

                    }
                    if ($('#month_days').val().trim() == '') {
                        $('#month_days').addClass('is-invalid');
                        isValid = false;
                    } else {
                        $('#month_days').removeClass('is-invalid');
                        $('#month_days').addClass('is-valid');

                    }

                    if ($('#restricted_days').val().trim() == '') {
                        $('#restricted_days').addClass('is-invalid');
                        isValid = false;
                    } else {
                        $('#restricted_days').removeClass('is-invalid');
                        $('#restricted_days').addClass('is-valid');

                    }
                    if ($('#accural_days').val().trim() == '') {
                        $('#accural_days').addClass('is-invalid');
                        isValid = false;
                    } else {
                        $('#accural_days').removeClass('is-invalid');
                        $('#accural_days').addClass('is-valid');

                    }


                    if ($('#instructions_notes').val().trim() == '') {
                        $('#instructions_notes').addClass('is-invalid');
                        isValid = false;
                    } else {
                        $('#instructions_notes').removeClass('is-invalid');
                        $('#instructions_notes').addClass('is-valid');

                    }


                }
                if (isValid == true) {

                    var createPolicyRow =
                        '<tr><td colspan="10"> <div> <table class="table  table-borderless"><tbody><tr><td colspan="2" style="max-width:19px;">' +
                        leaveType + '</td><td colspan="2">' + annualDays + '</td><td colspan="2">' +
                        monthDays +
                        '</td><td colspan="2">' +
                        restrictedDays + '</td><td colspan="2">' + accuralDays +
                        '</td></tr><tr> <td colspan="10 p-0"><div class="alert alert-danger mb-0 py-1 d-flex align-items-center" role="alert"><div class="d-flex justify-content-center"> <span class="text-warning fw-bold me-1">Note : </span><span class="  text-muted ">' +
                        leaveNotes + '</span> </div> </div></td></tr></tbody></table></div></td></tr>'
                    $('#policyTable').append(createPolicyRow);

                    // $('#addPolicy_form').removeClass('show');

                }



                $('.close-pop').click(function() {
                    clearValidations();

                });



                // clearValue();
                // clearValidations();
            });




        });
    </script>
@endsection
