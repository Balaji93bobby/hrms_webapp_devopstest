@extends('layouts.master')
@section('css')
<link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">
@endsection
@section('content')

{{-- @component('components.configuration_breadcrumb')
@slot('li_1') @endslot
@endcomponent --}}
    <div class="master-config-wrapper w-full">
        <div class="row ">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
                        <div id="msform">
                            <form id="form_config_master" method="POST" action="{{route('store-config-master')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="card top-line">
                                    <div class="card-body justify-content-center align-items-center mb-3">

                                            <h6 class="text-muted">Master Configuration</h6>

                                        <div class="form-card">
                                            <h6 class="mt-3">Onboarding : </h6>
                                            <div class="row mt-1">
                                                <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                                                    <label class="" >Employee Code Prefix</label>
                                                </div>
                                                <div class="col-md-7 col-lg-7 col-xxl-7 col-xl-7  col-sm-7 mt-2">
                                                    <input placeholder="" type="text" name="employee_code_prefix" value="{{ isset($data['employee_code_prefix']) ? $data["employee_code_prefix"] : "" }}" class="onboard-form form-control" required>
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                                                    <label class="" >Employee Code Median</label>
                                                </div>
                                                <div class="col-md-7 col-lg-7 col-xxl-7 col-xl-7  col-sm-7 mt-2">
                                                    <input placeholder="" type="text" name="employee_code_median" value="{{ isset($data['employee_code_median']) ? $data["employee_code_median"] : "" }}" class="onboard-form form-control" >
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                                                    <label class="" >Employee Code Suffix Series</label>
                                                </div>
                                                <div class="col-md-7 col-lg-7 col-xxl-7 col-xl-7  col-sm-7 mt-2">
                                                    <input placeholder="" type="number" name="employee_code_suffix_series" value="{{ isset($data['employee_code_suffix_series']) ? $data["employee_code_suffix_series"] : "" }}" class="onboard-form form-control" required>
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                                                    <label class="" >Can send <b>Appointment Letter PDF</b> after Onboard form submit?</label>
                                                </div>

                                                @if(isAppointmentLetterTemplateAvailable())
                                                <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">
                                                    @if($data['can_send_appointmentletter_after_onboarding'] == "true")
                                                        <input type="radio" id="true_option_can_send_appointmentletter_after_onboarding" name="can_send_appointmentletter_after_onboarding" class="" value="true" checked="checked">
                                                        <label for="true_option_can_send_appointmentletter_after_onboarding">Yes</label>
                                                        <input type="radio" id="false_option_can_send_appointmentletter_after_onboarding" name="can_send_appointmentletter_after_onboarding" value="false">
                                                        <label for="false_option_can_send_appointmentletter_after_onboarding">No</label>
                                                    @else
                                                        <input type="radio" id="true_option_can_send_appointmentletter_after_onboarding" name="can_send_appointmentletter_after_onboarding" value="true">
                                                        <label for="true_option_can_send_appointmentletter_after_onboarding">Yes</label>
                                                        <input type="radio" id="false_option_can_send_appointmentletter_after_onboarding" name="can_send_appointmentletter_after_onboarding" value="false" checked="checked">
                                                        <label for="false_option_can_send_appointmentletter_after_onboarding">No</label>
                                                    @endif
                                                </div>
                                                @else
                                                    <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">

                                                        <span><b> Error : Appointment letter template missing. Contact Admin.</b></span>
                                                        <input type="hidden" name="can_send_appointmentletter_after_onboarding" value="false">
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="row mt-1">
                                                <div class="col-md-5 col-xxl-5 col-lg-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                                                    <label class="" for="selected_head">Can send <b>Appointment Mail</b> after Onboard form submit?</label>
                                                </div>
                                                <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">
                                                    @if($data['can_send_appointmentmail_after_onboarding'] == "true")
                                                        <input type="radio" id="true_option_can_send_appointmentmail_after_onboarding" name="can_send_appointmentmail_after_onboarding" class="" value="true" checked="checked">
                                                        <label for="true_option_can_send_appointmentmail_after_onboarding">Yes</label>
                                                        <input type="radio" id="false_option_can_send_appointmentmail_after_onboarding" name="can_send_appointmentmail_after_onboarding" value="false">
                                                        <label for="false_option_can_send_appointmentmail_after_onboarding">No</label>
                                                    @else
                                                        <input type="radio" id="true_option_can_send_appointmentmail_after_onboarding" name="can_send_appointmentmail_after_onboarding" value="true">
                                                        <label for="true_option_can_send_appointmentmail_after_onboarding">Yes</label>
                                                        <input type="radio" id="false_option_can_send_appointmentmail_after_onboarding" name="can_send_appointmentmail_after_onboarding" value="false" checked="checked">
                                                        <label for="false_option_can_send_appointmentmail_after_onboarding">No</label>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <div class="col-md-5 col-xxl-5 col-lg-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                                                    <label class="" for="selected_head">Is <b>Employee Code</b> autogenerated in bulk onboarding?</label>
                                                </div>
                                                <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">
                                                    @if($data['is_employee_code_autogenerated_in_bulk_onboarding'] == "true")
                                                        <input type="radio" id="true_option_is_employee_code_autogenerated_in_bulk_onboarding" name="is_employee_code_autogenerated_in_bulk_onboarding" class="" value="true" checked="checked">
                                                        <label for="true_option_is_employee_code_autogenerated_in_bulk_onboarding">Yes</label>
                                                        <input type="radio" id="false_option_is_employee_code_autogenerated_in_bulk_onboarding" name="is_employee_code_autogenerated_in_bulk_onboarding" value="false">
                                                        <label for="false_option_is_employee_code_autogenerated_in_bulk_onboarding">No</label>
                                                    @else
                                                        <input type="radio" id="true_option_is_employee_code_autogenerated_in_bulk_onboarding" name="is_employee_code_autogenerated_in_bulk_onboarding" value="true">
                                                        <label for="true_option_is_employee_code_autogenerated_in_bulk_onboarding">Yes</label>
                                                        <input type="radio" id="false_option_is_employee_code_autogenerated_in_bulk_onboarding" name="is_employee_code_autogenerated_in_bulk_onboarding" value="false" checked="checked">
                                                        <label for="false_option_is_employee_code_autogenerated_in_bulk_onboarding">No</label>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                                                    <label class="" for="selected_head">Is <b>Employee Code</b> editable in normal onboarding?</label>
                                                </div>
                                                <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">
                                                    @if($data['is_employee_code_editable_in_normal_onboarding'] == "true")
                                                        <input type="radio" id="true_option_is_employee_code_editable_in_normal_onboarding" name="is_employee_code_editable_in_normal_onboarding" class="" value="true" checked="checked">
                                                        <label for="true_option_is_employee_code_editable_in_normal_onboarding">Yes</label>
                                                        <input type="radio" id="false_option_is_employee_code_editable_in_normal_onboarding" name="is_employee_code_editable_in_normal_onboarding" value="false">
                                                        <label for="false_option_is_employee_code_editable_in_normal_onboarding">No</label>
                                                    @else
                                                        <input type="radio" id="true_option_is_employee_code_editable_in_normal_onboarding" name="is_employee_code_editable_in_normal_onboarding" value="true">
                                                        <label for="true_option_is_employee_code_editable_in_normal_onboarding">Yes</label>
                                                        <input type="radio" id="false_option_is_employee_code_editable_in_normal_onboarding" name="is_employee_code_editable_in_normal_onboarding" value="false" checked="checked">
                                                        <label for="false_option_is_employee_code_editable_in_normal_onboarding">No</label>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-1">
                                            <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                                                <label class="" for="selected_head">Select Organization HR</label>
                                            </div>
                                            <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">
                                                <select placeholder="Select HR" name="hr_userid"
                                                    class="onboard-form form-control">
                                                    <option value="">Select</option>
                                                    @foreach ($employees_hr as $singleHr)
                                                            <option value="{{ $singleHr->id}}" @if( $singleHr->id == $data['hr_userid']) selected @endif>{{ $singleHr->name}}</option>

                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5 mt-2">
                                                <label class="" for="selected_head"> Attendance Modes</label>
                                            </div>

                                            <div class="col-md-7 col-sm-7 col-xs-7 col-lg-7 mt-2">


                                                <input name="attendancemode_web" type="checkbox" value="web">
                                                <label for="attendancemode_web"> Web</label>
                                                <input name="attendancemode_mobile" type ="checkbox"value="mobile">
                                                <label for="attendancemode_moblie">  Moblie</label>
                                                <input name="attendancemode_biometric" type="checkbox" value="biometric">
                                                <label for="attendancemode_biometric">Biometric</label>
                                            </div>
                                            </div>
                                            <div class="text-primary my-2 header-card-text">
                                                <div class="col-12 text-right"><button type="submit" data="row-6" next="row-6" placeholder="" id="next" class="btn btn-orange   text-center">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </form>
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

<!-- for validating -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.19.0/jquery.validate.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

    $(document).ready(function() {
        $('.select2_form_without_search').each(function() {
            var placeholder = $(this).attr('placeholder')
            placeholder = (placeholder == undefined) ? '' : placeholder;

            $(this).select2({
                width: '100%',
                minimumResultsForSearch: Infinity,
                placeholder: placeholder,
            });
        });

        var array_data = $.map({!! $employees_hr !!}, function (obj) {
            obj.text = obj.name +" ("+ obj.user_code+")"; //

            return obj;
        });

        $('#hr_userid').select2({
                data : array_data,
        });
    });
</script>

@endsection
