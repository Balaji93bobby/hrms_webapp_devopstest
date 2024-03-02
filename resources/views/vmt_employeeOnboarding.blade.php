@extends('layouts.master')
{{-- @include('ui-onboarding')
 --}}
@section('css')
    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/onboarding.css') }}">


    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .floating input {
            width: 100% !important;
            margin-left: 0 !important;
            height: 2.9em;
        }

        #current_address_copy {
            height: 12px !important;
            width: 12px !important;
        }

        .addfiles {
            padding: 7px;
            border-radius: 2px;
        }

        .loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('{{ URL::asset('assets/images/loader.gif') }}') 50% 50% no-repeat rgb(249, 249, 249);
            opacity: 0.4;
        }
    </style>
@endsection

@section('content')
    {{-- @component('components.organization_breadcrumb')
        @slot('li_1')
        @endslot
    @endcomponent --}}
    <div class="loader" style="display:none;"></div>

    {{-- Show Only if employee is already onboarded --}}
    @if (!empty($employee_user) && $employee_user->is_onboarded == '1')
        @component('components.organization_breadcrumb')
            @slot('li_1')
            @endslot
        @endcomponent
    @endif

    <div class="main">
        @if (Request::has('debug'))
            @include('ui-onboarding-debug')
        @else
            @include('ui-onboarding')
        @endif

    @endsection
    @section('script')
        <!-- ui notifications -->

        <script src="{{ URL::asset('/assets/libs/prismjs/prismjs.min.js') }}"></script>
        <script src="{{ URL::asset('/assets/js/pages/notifications.init.js') }}"></script>
        <!-- apexcharts -->

        <!-- dashboard init -->

        <!--Page Wrapper-->


        <!-- jQuery easing plugin -->
        <!-- <script src="http://thecodeplayer.com/uploads/js/jquery.easing.min.js" type="text/javascript"></script> -->

        <script src="{{ URL::asset('/assets/premassets/js/sweetalert.js') }}"></script>
        <!--Progressbar JS-->
        <script src="{{ URL::asset('/assets/premassets/js/progressbar.min.js') }}"></script>
        <!--Charts-->
        <!--Canvas JS-->
        <!--Custom Js Script-->
        <!--Custom Js Script-->
        <script src="{{ URL::asset('/assets/premassets/js/custom.js') }}"></script>
        <script src="{{ URL::asset('/assets/premassets/js/onboarding.js') }}"></script>

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



        <!-- <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.19.0/jquery.validate.min.js"></script> -->

        {{-- for date picker --}}

        {{-- <link rel="stylesheet" href="dist/datepicker.min.css">
    <script src="dist/datepicker.min.js"></script> --}}





        <script>
            // function onlyNumberKey(evt) {

            //     // Only ASCII character in that range allowed
            //     var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            //     if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            //         return false;
            //     return true;
            // }
            var isEmailExists = false;

            function numberOnly(id) {
                // Get element by id which passed as parameter within HTML element event
                var element = document.getElementById(id);
                // This removes any other character but numbers as entered by user
                element.value = element.value.replace(/[^0-9]/gi, "");
            }






            $(document).ready(function() {

                // $('input[@type="text"]')[0].focus();

                $("input[type='text']").on("click", function() {
                    $(this).select();
                });
                $("input").focus(function() {
                    $(this).select();
                });
                $("input").focusin(function() {
                    $(this).select();
                });




                $('#gender').val('other').trigger("change");
                console.log('Gender from DB : ' +
                    '{{ !empty($employee_details) && $employee_details->gender ? $employee_details->gender : '' }}');
                $('#process').select2({
                    width: '100%',
                    placeholder: "Select Process",
                });
                $('#department').select2({
                    width: '100%',
                    placeholder: "Select Department",
                });

                $('#nationality').select2({
                    placeholder: "Select Nationality",
                    width: '100%'
                });
                $('#marital_status').select2({
                    placeholder: "Select Marital Status",
                    width: '100%'

                });





                $('#l1_manager_code_select').select2({
                    width: '100%',
                    placeholder: "Select Reporting Manager",
                });

                $('#l1_manager_code_select').on('select2:select', function(e) {
                    var usercode = e.params.data.text;

                    //http://localhost:8000/getEmployeeName?user_code=EMP100
                    $.ajax({
                        url: "{{ route('get-employee-name') }}",
                        type: "GET",
                        data: {
                            user_code: usercode,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            $('#l1_manager_name').val(data);
                        }
                    });
                    // console.log(usercode);
                });


                $('#passport_no').on('input focus', function() {
                    console.log("validating passport");
                    var patt = new RegExp("^[A-PR-WYa-pr-wy][1-9]\\d\\s?\\d{4}[1-9]$");
                    var txtValue = $(this).val();
                    var maxLength = $(this).attr('maxlength');

                    if (txtValue.trim().length == maxLength) {
                        if (patt.test(txtValue)) {
                            return true;
                        } else {
                            $('#error_passport_no').html("Passport is not valid");
                            return false;
                        }
                    } else {
                        $('#error_passport_no').html("");
                        return true;
                    }
                });


                $('#employee_name').css('text-transform', 'capitalize');


                $('.select2_form_without_search').each(function() {
                    var placeholder = $(this).attr('placeholder')
                    placeholder = (placeholder == undefined) ? '' : placeholder;

                    $(this).select2({
                        width: '100%',
                        minimumResultsForSearch: Infinity,
                        placeholder: placeholder,
                    });
                });


                $('#aadhar_backend').click(function() {
                    if ($('#aadhar_backend').is(':checked')) {
                        $('#aadhar_card_backend_content').show();
                        $('#aadhar_card_backend').attr('require', true);
                        $('#aadhar_card_backend_req').show();
                    } else {
                        $('#aadhar_card_backend_content').hide();
                        $('#aadhar_card_backend').removeAttr('require');
                        $('#aadhar_card_backend_req').hide();
                    }
                });

                $('.calculation_data').keyup(function() {
                    var gross = 0;
                    var cic = 0;
                    var net = 0;
                    $.each($('.gross_data'), function(value) {
                        if ($(this).val()) {
                            gross += parseInt($(this).val());
                        }
                    });
                    $.each($('.cic_data'), function(value) {
                        if ($(this).val()) {
                            cic += parseInt($(this).val());
                        }
                    });
                    $.each($('.net_data'), function(value) {
                        if ($(this).val()) {
                            net += parseInt($(this).val());
                        }
                    });
                    console.log(gross);
                    $('#gross').val(gross);
                    $('#cic').val(gross + cic);
                    $('#net_income').val(gross - cic + net);
                });

                $('#bank_names').select2({
                    width: '100%',
                    placeholder: "Select Bank Name",
                });

                $('#bank_names').on('click', function() {
                    console.log("hello");
                    //$( "#target" ).focus();
                });

                $('#bank_names').change(function() {
                    var min = $('#bank_names option:selected').attr('min-data');
                    var max = $('#bank_names option:selected').attr('max-data');

                    //$('#account_no').val('');
                    $('#account_no').attr('minlength', min);
                    $('#account_no').attr('maxlength', max);
                })

                $('body').on('click', '.close-modal', function() {
                    $('#notificationModal').hide();
                    $('#notificationModal').addClass('fade');
                });

                $('.onboard-form').keyup(function() {
                    this.value = this.value.toLowerCase();
                    this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);
                }).trigger('keyup');


                $('#pan_num').on('input', function() {

                    var patt = /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/;
                    var txtValue = $(this).val();
                    var maxLength = $(this).attr('maxlength');

                    if (txtValue.trim().length == maxLength) {
                        if (patt.test(txtValue)) {
                            return true;
                        } else {
                            $('#error_pan_no').html("PAN number is not valid");
                            return false;
                        }
                    } else {
                        $('#error_pan_no').html("");
                        return true;
                    }
                });

                //Employee Gender Populate

                $('#gender').change(function() {
                    var gender = $(this).val();
                    var mygender = $('#gender :selected').text();

                    if ($('marital_status').val('married')) {
                        if (mygender == "Male") {

                            $('#spouse_gender').val('female').trigger('change').prop('disabled', true);
                        } else if (mygender == "Female") {

                            $('#spouse_gender').val('male').trigger('change').prop('disabled', true);
                        }
                    } else if ($('marital_status').val('widowed')) {
                        if (mygender == "Male") {

                            $('#spouse_gender').val('female').trigger('change').prop('disabled', true);
                        } else if (mygender == "Female") {
                            $('#spouse_gender').val('male').trigger('change').prop('disabled', true);
                        }
                    } else if ($('marital_status').val('separated')) {

                        if (mygender == "Male") {
                            console.log("Male selected");
                            $('#spouse_gender').val('female').trigger('change').prop('disabled', true);
                        } else if (mygender == "Female") {
                            $('#spouse_gender').val('male').trigger('change').prop('disabled', true);
                        }
                    } else if ($('marital_status').val('divorced')) {

                        if (mygender == "Male") {
                            console.log("Male selected");
                            $('#spouse_gender').val('female').trigger('change').prop('disabled', true);
                        } else if (mygender == "Female") {
                            $('#spouse_gender').val('male').trigger('change').prop('disabled', true);
                        }
                    } else if ($('#marital_status').val('unmarried')) {

                        if (mygender == "Male") {
                            $('#spouse_gender').val('').prop('disabled', true);
                            console.log("female unmarried");
                        } else if (mygender == "Female") {
                            $('#spouse_gender').val('').prop('disabled', true);
                            console.log("male unmarried");
                        }



                    }
                })
                //End Employee Gender Populate

                //Nationality Validation

                $('#nationality').change(function() {
                    var nationality = $(this).val();
                    var mynationality = $('#nationality :selected').text();

                    if ($('nationality').val('indian')) {

                        $("#passport_no").removeAttr("required");
                        $('#passdate').removeAttr("required");
                    } else if ($('nationality').val('other_country')) {
                        $("#passport_no").attr("required");
                        $("#passdate").attr("required");
                        // $('#passport_no').addClass('error');
                        // $('#passport_date').addClass('error');
                        $("#passport_date").attr("required");
                    }
                });





                //End Nationality Validation



                //PAN Validation

                //End Pan Validation

                // $('#vmt_aadhar').on('input', function() {
                //     var aadharno = new RegExp("^[2-9]{1}[0-9]{3}\s{1}[0-9]{4}\s{1}[0-9]{4}$");
                //     var aadhartes = $("#vmt_aadhar").val();
                //     if (aadharno.test(aadhartes)) {
                //         return true;
                //     } else {
                //         alert("Please Enter Valid Aadhar Number");
                //     }
                //     return false;
                // });

                // $('#epf_number').on('input', function(){

                // //Sample Data :  TN MAS 054110 000 0054321

                //     var patt = /^([A-Z]{2}\s)([A-Z]{3}\s)([0-9]{1,7}\s)([0-9]{3}\s)?([0-9]{1,7})$/;
                //     var txtValue = $(this).val();
                //     var maxLength = $(this).attr('maxlength');

                //     if ( txtValue.trim().length == maxLength)
                //     {
                //         if( patt.test(txtValue)){
                //             return true;
                //         }
                //         else {
                //             $('#error_epf_number').html("EPF number is not valid");
                //             return false;
                //         }
                //     }
                //     else
                //     {
                //         $('#error_epf_number').html("");
                //         return true;
                //     }
                // });


                // $('#esic_number').on('input', function(){

                //     //Sample Data :  31–00–123456–000–0000

                //     var patt = /^(\d{2})[-–\s]?(\d{2})[-–\s]?(\d{1,6})[-–\s]?(\d{3})[-–\s]?(\d{4})$/;
                //     var txtValue = $(this).val();
                //     var maxLength = $(this).attr('maxlength');

                //     if ( txtValue.trim().length == maxLength)
                //     {
                //         if( patt.test(txtValue)){
                //             return true;
                //         }
                //         else {
                //             $('#error_esic_number').html("ESIC number is not valid");
                //             return false;
                //         }
                //     }
                //     else
                //     {
                //         $('#error_esic_number').html("");
                //         return true;
                //     }
                // });

                $('#vmt_aadhar').on('input', function() {

                    var patt = /^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$/;
                    var txtValue = $(this).val();
                    var maxLength = $(this).attr('maxlength');

                    if (txtValue.trim().length == maxLength) {
                        console.log("same length");
                        if (patt.test(txtValue)) {
                            return true;
                        } else {
                            $('#error_vmt_aadhar').html("Aadhar number is not valid");
                            return false;
                        }
                    }
                    if (txtValue.trim().length > maxLength) {
                        return false;
                    }
                });

                $('#dob_father').on('change', function() {
                    var txtValue = $(this).val();
                    $('#father_age').val(getAge(txtValue));

                    if ($('#father_age').val()> 2) {
                        $('#father_age').removeClass('error');
                        $('#father_age-error').css('display','none');
                    }
                    else{
                        $('#father_age').addClass('error');
                        $('#father_age-error').css('display','block');

                    }

                });

                $('#dob_mother').on('change', function() {
                    var txtValue = $(this).val();
                    $('#mother_age').val(getAge(txtValue));
                    if ($('#mother_age').val()> 2) {
                        $('#mother_age').removeClass('error');
                        $('#mother_age-error').css('display','none');
                    }
                    else{
                        $('#mother_age').addClass('error');
                        $('#mother_age-error').css('display','block');

                    }

                });

                $('#email').on('input', function() {
                    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

                    if (!regex.test($(this).val())) {
                        console.log("Invalid Email");

                        return false;
                    } else {
                        console.log("Valid Email");
                        //Check if email already exists
                        var routeURL = "{{ route('isEmailExists', ':email') }}";
                        routeURL = routeURL.replace(':email', $(this).val());

                        //Check only if this is normal onboarding

                        $.ajax({
                            url: routeURL,
                            type: "GET",
                            success: function(data) {
                                console.log("(isEmailExists :: AJAX call response : " + data);

                                $('#error_email').html("");

                                if (data == "true") {
                                    $('#error_email').html("Email already exists");
                                    isEmailExists = true;

                                } else {
                                    isEmailExists = false;
                                }
                            }
                        });

                        return true;
                    }
                });

                function checkEmpCodeExists(emp_code) {

                    //Check if email already exists
                    var routeURL = "{{ route('isEmpCodeExists', ':emp_code') }}";

                    routeURL = routeURL.replace(':emp_code', emp_code);

                    $.ajax({
                        url: routeURL,
                        type: "GET",
                        success: function(data) {
                            console.log("isEmpCodeExists :: AJAX call response : " + data);

                            $('#error_emp_code').html("");

                            if (data == "true") {

                                console.log(emp_code + " already exists!");

                                $('#error_emp_code').html(
                                    "Employee code already exists. Re-enter new code.");
                                $('#employee_code').removeAttr('readonly');

                                $('#modalHeader').html("Error");
                                $('#modalSubHeading').html("Please fix the below issue");
                                $('#modalBody').html("Employee code already exists. Re-enter new code.");
                                $('#notificationModal').show();
                                $('#notificationModal').removeClass('fade');

                                errors_core_fields.push("Employee code already exists. Re-enter new code.");

                                is_core_fields_valid = false;
                            } else {
                                console.log(emp_code + " doesnt exists");

                            }

                        }
                    });
                }

                function getAge(dateString) {
                    var today = new Date();
                    var birthDate = new Date(dateString);
                    var age = today.getFullYear() - birthDate.getFullYear();
                    var m = today.getMonth() - birthDate.getMonth();
                    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }
                    return age;
                }

                // $('#dl_no').on('input', function(){

                //     var patt = /^([A-Z]{2})(\d{2}|\d{3})[a-zA-Z]{0,1}(\d{4})(\d{7})$/;
                //     var txtValue = $(this).val();
                //     var maxLength = $(this).attr('maxlength');

                //     if ( txtValue.trim().length == maxLength)
                //     {
                //         if( patt.test(txtValue)){
                //             return true;
                //         }
                //         else {
                //             $('#error_dl_no').html("DL number is not valid");
                //             return false;
                //         }
                //     }
                //     else
                //     {
                //         $('#error_dl_no').html("");
                //         return true;
                //     }
                // });

                $('#pan_ack').keyup(function() {
                    if ($('#pan_ack').val() == '') {
                        $('#pan_ack').removeAttr('required');
                        $('#pan_no').removeAttr('disabled');
                        $('#pan_no').attr('required', true);
                        $('#pan_no_req').show();
                        $('#pan_no').attr('pattern', 'pan');
                        $('#pan_no_label').addClass('patternErr');
                        $('#pan_ack').addClass('not-required validate');
                        $('#pan_ack_req').hide();
                    } else {
                        $('#pan_no').removeAttr('required');
                        $('#pan_no').val('');
                        $('#pan_no').attr('disabled', true);
                        $('#pan_no').removeAttr('pattern');
                        $('#pan_ack').attr('required', true);
                        $('#pan_ack_req').show();
                        $('#pan_no_label').removeClass('patternErr');
                        $('#pan_no_label').hide();
                        $('#pan_ack').removeClass('not-required validate');
                        $('#pan_no_req').hide();
                    }
                })

                $('#no_child').change(function() {
                    var val = $('#no_child').val();
                    var data = "";
                    for (var i = 1; i <= val; i++) {
                        var childName = $('input[name="child_name' + i + '"]').val();
                        var childDob = $('input[name="child_dob' + i + '"]').val();
                        var childGender = $('input[name="child_gender' + i + '"]').val();
                        // // // data = data+"<div class='col-md-3 col-sm-3 col-xs-6 col-lg-3 mt-2'><label class='' for='child_name"+i+"'>Children Name</label><input type='text' name='child_name[]' id='child_name"+i+"' class='onboard-form form-control spouse_data' required /></div><div class='col-md-3 col-sm-3 col-xs-6 col-lg-3 mt-3'><label class='' for='child_dob"+i+"'>Children DOB</label><input type='date' name='child_dob[]' id='child_dob"+i+"' class='onboard-form form-control spouse_data' required /></div><div class='col-md-3 col-sm-3 col-xs-6 col-lg-3 mt-3'><label class='' for='child_gender"+i+"'>Children Gender</label><select name='child_gender[]' id='child_gender"+i+"' class='onboard-form form-control spouse_data' required ><option value=''>Select</option><option value='male'>Male</option><option value='female'>Female</option><option value='other'>Other</option></select></div>";
                    }
                    $('.children_container').html(data);
                });



                $('#marital_status').change(function() {
                    if ($('#marital_status').val() == 'unmarried') {
                        $.each($('.spouse_data'), function(value) {
                            var name = $(this).attr('name');
                            if ($('input[name="' + name + '"]').val() == '') {
                                $('.' + name + '_label').hide();
                            }
                            $(this).attr('disabled', true);
                            $(this).removeAttr('required');
                            $(this).addClass('not-required validate');
                            $('#spouse_gender').val('');
                            $('#' + name + '_req').hide();

                        });
                    } else {
                        $.each($('.spouse_data'), function(value) {
                            var name = $(this).attr('name');
                            $(this).removeAttr('disabled');
                            $(this).attr('required', true);
                            $(this).removeClass('not-required validate');
                            $('#' + name + '_req').show();
                        });
                        if ($('#gender').val() == 'male') {
                            $('#spouse_gender').val('female');
                        } else {
                            $('#spouse_gender').val('male');
                        }
                    }
                });

                $('#gender').change(function() {
                    if ($('#marital_status').val() == 'unmarried') {
                        $('#spouse_gender').val('');
                    } else {
                        if ($('#gender').val() == 'male') {
                            $('#spouse_gender').val('female');
                        } else {
                            $('#spouse_gender').val('male');
                        }
                    }
                });

                $('#current_state').select2({
                    width: '100%',
                    placeholder: "Select State",
                });

                $('#permanent_state').select2({
                    width: '100%',
                    placeholder: "Select State",
                });

                $('#current_country').select2({
                    width: '100%',
                    placeholder: "Select Country",
                });

                $('#permanent_country').select2({
                    width: '100%',
                    placeholder: "Select Country",
                });

                $('#ptax_location').select2({
                    width: '100%',
                    placeholder: "Select location",
                });

                $('#lwf_location').select2({
                    width: '100%',
                    placeholder: "Select location",
                });

                $('#holiday_location').select2({
                    width: '100%',
                    placeholder: "Select location",
                });



                $('#nationality').change(function() {
                    console.log("Changed nationality : " + $('#nationality').val());
                    // $('#permanent_country').val('IN').trigger('change');
                    if ($('#nationality').val() == 'indian') {

                        $('#passport_no').removeAttr('required');
                        $('#passport_no_req').hide();
                        if ($('#passport_no').val() == '') {
                            // $('.passport_no_label').hide();
                        }
                        $('#passport_no').addClass('not-required validate');
                        $('#passport_exp').addClass('not-required validate');
                        // $('#passport_exp').removeAttr('required');
                        $('#passport_exp_req').hide();
                        $('.passport_exp_label').hide();
                        $('#aadhar').attr('required', true);
                        $('#aadhar_req').show();
                        $('#aadhar').removeClass('not-required validate');
                        $('#permanent_pincode').attr('type', 'text');
                        $('#current_pincode').attr('type', 'text');
                        $('#current_country').val('103').trigger('change');
                        stateFunction('IN', '#current_state');
                        stateFunction('IN', '#permanent_state');
                        $('#asterisk_passport_no').html('');
                        $('#asterisk_passport_expdate').html('');
                        $('#passport_no').removeClass('error');
                        $('#passport_date').removeClass('error');
                        $('#error_passport_no').removeClass('error');
                        $('#passport_date-error').removeClass('error');
                    } else {

                        $('#passport_no').attr('required', true);
                        $('#passport_date').attr('required', true);
                        $('#passport_no').addClass('error');
                        $('#passport_date').addClass('error');

                        $('#passport_no_req').show();
                        $('#passport_exp_req').show();
                        $('#passport_no').removeClass('not-required validate');
                        $('#passport_exp').removeClass('not-required validate');
                        $('#passport_exp').attr('required', true);
                        $('#aadhar').removeAttr('required');
                        if ($('#aadhar').val() == '') {
                            $('.aadhar_label').hide();
                        }
                        $('#permanent_pincode').attr('type', 'text');
                        $('#current_pincode').attr('type', 'text');
                        $('#aadhar').addClass('not-required validate');
                        $('#aadhar_req').hide();
                        $('#current_state').val('AF').trigger('change');
                        $('#current_country').val('').trigger('change');

                        stateFunction('AF', '#current_state');

                        $('#asterisk_passport_no').html('*');
                        $('#asterisk_passport_expdate').html('*');


                    }
                });

                $('#passport_no_req').hide();
                $('#passport_exp_req').hide();
                stateFunction('IN', '#ptax_location');
                stateFunction('IN', '#lwf_location');
                stateFunction('IN', '#holiday_location');

                stateFunction('IN', '#current_state');

                stateFunction('IN', '#permanent_state');

                populateGenderDropdown('#gender');
                populateMaritalStatusDropdown();

                $('#current_address_copy').change(function() {
                    if ($('#current_address_copy').is(':checked')) {
                        // stateFunction($('#current_district').val(), '#permanent_state', true);
                        $('#permanent_state').val($('#current_state').val()).trigger('change');
                        $('#permanent_pincode').val($('#current_pincode').val());
                        $('#permanent_country').val($('#current_country').val()).trigger('change');
                        $('#permanent_state').val($('#current_state').val());
                        $('#permanent_city').val($('#current_city').val());
                        $('#permanent_address_line_1').val($('#current_address_line_1').val());
                        $('#permanent_address_line_2').val($('#current_address_line_2').val());
                    } else {
                        $('#permanent_pincode').val('');
                        $('#permanent_country').val('').trigger('change');
                        $('#permanent_state').val('').trigger('change');
                        $('#permanent_city').val('');
                        $('#permanent_address_line_1').val('');
                        $('#permanent_address_line_2').val('');
                    }
                });

                function populateGenderDropdown(element_id) {

                    var genderValues = [];
                    genderValues['male'] = 'Male';
                    genderValues['female'] = 'Female';
                    genderValues['other'] = 'Other';

                    var backend_value = "";

                    if (element_id == '#gender') {
                        backend_value =
                            "{{ !empty($employee_details) && $employee_details->gender ? $employee_details->gender : '' }}";
                    }

                    //create the dropdown
                    const keys = genderValues.keys();
                    console.log("Gender array : " + genderValues);

                    for (var key in genderValues) {
                        if (key == backend_value)
                            $(element_id).append('<option value="' + key + '" selected>' + genderValues[key] +
                                '</option>');
                        else
                            $(element_id).append('<option value="' + key + '">' + genderValues[key] + '</option>');

                    }

                }

                function populatePhysicalChallenge() {
                    var physicalChallenged = [];
                    physicalChallenged['no'] = 'No';
                    physicalChallenged['yes'] = 'Yes';
                    var physicalChallenge_value =
                        "{{ !empty($employee_details) && $employee_details->physically_challenged ? $employee_details->physically_challenged : '' }}";
                    const keys = physicalChallenged.keys();

                    for (var key in physicalChallenged) {
                        if (key == physicalChallenge_value)
                            $('#physically_challenged').append('<option value="' + key + '" selected>' +
                                physicalChallenged[key] + '</option>').trigger('change');
                        else
                            $('#physically_challenged').append('<option value="' + key + '">' + physicalChallenged[
                                key] + '</option>').trigger('change');

                    }

                }
                populatePhysicalChallenge();

                function populateMaritalStatusDropdown() {
                    var marital_status = [];
                    marital_status['unmarried'] = 'Unmarried';
                    marital_status['married'] = 'Married';
                    marital_status['widowed'] = 'Widowed';
                    marital_status['separated'] = 'Separated';
                    marital_status['divorced'] = 'Divorced';
                    var backend_value =
                        "{{ !empty($employee_details) && $employee_details->marital_status ? $employee_details->marital_status : '' }}";

                    //create the dropdown
                    const keys = marital_status.keys();

                    for (var key in marital_status) {
                        if (key == backend_value)
                            $('#marital_status').append('<option value="' + key + '" selected>' + marital_status[key] +
                                '</option>').trigger('change');

                        // $('#permanent_country').val($('#current_country').val()).trigger('change');
                        else
                            $('#marital_status').append('<option value="' + key + '">' + marital_status[key] +
                                '</option>').trigger('change');

                    }

                }


                @if (!empty($employee_details) && $employee_details->nationality)
                    console.log('{{ $employee_details->nationality }}');
                    $('#nationality').val('{{ $employee_details->nationality }}').trigger('change');
                @endif

                @if (!empty($emp_statutory_details) && $emp_statutory_details->pf_applicable)

                    $('#pf_applicable').val('{{ $emp_statutory_details->pf_applicable }}').trigger('change');
                @endif

                @if (!empty($emp_statutory_details) && $emp_statutory_details->esic_applicable)

                    $('#esic_applicable').val('{{ $emp_statutory_details->esic_applicable }}').trigger('change');
                @endif

                @if (!empty($emp_statutory_details) && $emp_statutory_details->tax_regime)

                    $('#tax_regime').val('{{ $emp_statutory_details->tax_regime }}').trigger('change');
                @endif


                @if (!empty($emp_office_details) && $emp_office_details->department_id)

                    $('#department').val('{{ $emp_office_details->department_id }}').trigger('change');
                @endif

                @if (!empty($employee_details->bank_id) && $employee_details->bank_id)
                    $('#bank_names').val('{{ $employee_details->bank_id }}').trigger('change');
                @endif


                @if (!empty($emp_office_details) && $emp_office_details->probation_period)
                    $('#probation_period').val('{{ $emp_office_details->probation_period }}').trigger('change');
                @endif

                @if (!empty($emp_office_details) && $emp_office_details->confirmation_period)
                    $('#confirmation_period').val('{{ $emp_office_details->confirmation_period }}').trigger('change');
                @endif

                @if (!empty($employee_details->no_of_children) && $employee_details->no_of_children)
                    $('#no_of_children').val('{{ $employee_details->no_of_children }}').trigger('change');
                @endif

                @if (!empty($employee_details) && $employee_details->dob)
                    $('#dob').val('{{ $employee_details->dob }}');
                @endif

                @if (!empty($employee_details) && $employee_details->passport_date)
                    $('#passport_date').val('{{ $employee_details->passport_date }}');
                @endif

                @if (!empty($emp_family_details))
                    @foreach ($emp_family_details as $details)
                        @if (!empty($details->relationship) && $details->relationship == 'Father')
                            $('#father_name').val('{{ $details->name }}').trigger('change');
                            $('#dob_father').val('{{ $details->dob }}').trigger('change');
                        @elseif (!empty($details->relationship) && $details->relationship == 'Mother')
                            $('#mother_name').val('{{ $details->name }}').trigger('change');
                            $('#dob_mother').val('{{ $details->dob }}').trigger('change');
                        @elseif (!empty($details->relationship) && $details->relationship == 'Spouse')
                            $('#spouse_name').val('{{ $details->name }}').trigger('change');
                            $('#dob_spouse').val('{{ $details->dob }}').trigger('change');
                            $('#spouse_gender').val('{{ $details->gender }}').trigger('change');
                            $('#wedding_date').val('{{ $details->wedding_date }}').trigger('change');
                        @endif
                    @endforeach
                @endif

                function stateFunction(id, dataId) {
                    var val = $('#current_state').val();
                    $(dataId).empty();

                    var backend_value = "";
                    //set a value if already exists in DB for this employee
                    if (dataId == '#ptax_location')
                        backend_value =
                        "{{ !empty($emp_statutory_details) && $emp_statutory_details->ptax_location_state_id ? $emp_statutory_details->ptax_location_state_id : '' }}";
                    else
                    if (dataId == '#lwf_location')
                        backend_value =
                        "{{ !empty($emp_statutory_details) && $emp_statutory_details->lwf_location_state_id ? $emp_statutory_details->lwf_location_state_id : '' }}";
                    else
                    if (dataId == '#holiday_location')
                        backend_value =
                        "{{ !empty($emp_office_details) && $emp_office_details->holiday_location ? $emp_office_details->holiday_location : '' }}";
                    else
                    if (dataId == '#current_state')
                        backend_value =
                        "{{ !empty($employee_details) && $employee_details->current_state_id ? $employee_details->current_state_id : '' }}";
                    else
                    if (dataId == '#permanent_state')
                        backend_value =
                        "{{ !empty($employee_details) && $employee_details->permanent_state_id ? $employee_details->permanent_state_id : '' }}";

                    console.log(dataId + " : " + backend_value);


                    $.ajax({
                        url: "{{ route('state') }}",
                        type: "POST",
                        data: {
                            code: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            $(dataId).append('<option value="">Select State</option>');

                            $.each(data, function(key, value) {

                                //if data already exists in back-end , then make it selected
                                //Only for holiday location
                                if (dataId == '#holiday_location' && backend_value == value
                                    .state_name) {
                                    $(dataId).append('<option value="' + value.id + '" selected>' +
                                        value.state_name + '</option>');
                                    console.log("Updated dropdown value for " + dataId);
                                } else
                                if (backend_value == value.id) {
                                    $(dataId).append('<option value="' + value.id + '" selected>' +
                                        value.state_name + '</option>');
                                    console.log("Updated dropdown value for " + dataId);
                                } else {
                                    $(dataId).append('<option value="' + value.id + '">' + value
                                        .state_name + '</option>');
                                }

                            });
                            if (val) {
                                $('#permanent_state').val($('#current_state').val());
                            }

                        }
                    });
                }


                var error_fields = "";

                $('.processOnboardForm').on('click', function(e) {
                    console.log("Selected Button : " + $(this).attr('name'));

                    var can_onboard_employee = "0";
                    let form_data1 = $("#form-1");

                    //check whether the minimum required details are filled
                    console.log("Emp name : " + $('#employee_name').val());
                    console.log("Emp code : " + $('#employee_code').val());
                    console.log("Email : " + $('#email').val());

                    var basic_details_errors = [];

                    if ($('#employee_name').val() == '')
                        basic_details_errors.push("Employee Name");

                    if ($('#employee_code').val() == '')
                        basic_details_errors.push("Employee Code");

                    if ($('#doj').val() == '')
                        basic_details_errors.push("Date Of Joining");


                    if ($('#email').val() == '')
                        basic_details_errors.push("Email");

                    console.log(basic_details_errors);


                    if (basic_details_errors.length > 0) {

                        $('#modalHeader').html("Please fill the following details");
                        $('#modalBody').html('');
                        $('#modalBody').append("<ul class='list-style-numbered list-style-circle px-4'>");
                        basic_details_errors.forEach(function(element) {
                            $('.list-style-numbered ').append('<li>' + element + '</li>');
                        });
                        $('#modalBody').append("</ul>");
                        // $('#modalSubHeading').append(element);


                        // for(let a in basic_details_errors )
                        // {
                        //     $('#modalSubHeading').val(a);
                        //    // console.log(a);
                        // }

                        $('#notificationModal').show();
                        $('#notificationModal').removeClass('fade');

                        return;
                    }

                    //  var form = $("#Form");

                    // you can't pass Jquery form it has to be javascript form object
                    //var formData = new FormData(form_data1[0]);


                    //check if mail exists
                    if (isEmailExists == true) {
                        console.log("Unable to submit form. Email already exists");

                        $('#modalHeader').html("Error");
                        $('#modalSubHeading').html("Email already exists!");
                        $('#notificationModal').show();
                        $('#notificationModal').removeClass('fade');

                        return;
                    }

                    if ($(this).attr('name') == "save_form") //Form is saved but employee not onboarded
                    {
                        console.log(form_data1);
                        var formData = new FormData($("#form-1")[0]);
                        console.log("Saving Onboard data");
                        saveOrSubmitForm("0", formData);
                        $('#submit_button').prop('disabled', false);
                        return;
                    }

                    //Find whether SAVE or SUBMIT button clicked
                    if ($('#form-1').valid()) {

                        //alert("1 st one");

                        // console.log(form_data1.values());
                        // for (var pair of form_data1.entries())
                        // {
                        //     console.log(pair[0]+ ', '+ pair[1]);
                        // }

                        $('.loader').show();
                        if ($(this).attr('name') == "submit_form") //Form is saved and employee is onboarded
                        {
                            console.log("Submitting Onboard data");
                            var formData = new FormData($("#form-1")[0]);
                            saveOrSubmitForm("1", formData);
                        }

                    } else {
                        console.log("Form validation failed");
                        console.log(error_fields);

                        $('#modalHeader').html("Error");
                        $('#modalSubHeading').html("The following fields are not filled.");
                        $('#modalBody').html(error_fields);
                        $('#notificationModal').show();
                        $('#notificationModal').removeClass('fade');
                    }

                });

                function showLoader() {

                    Swal.fire({
                        title: 'Info',
                        text: 'Please wait...',
                        allowOutsideClick: false,
                        closeOnClickOutside: false,
                        allowEscapeKey: false,
                        showConfirmButton: true,
                
                    }).then((result) => {
                        /* Read more about handling dismissals below */
                        console.log('Loader screen closed');

                    });

                }

                function saveOrSubmitForm(t_can_onboard_employee, t_form_data1) {

                    console.log("Aadhar file : " + $('#aadhar_card_file').val());
                    t_form_data1.append('can_onboard_employee', t_can_onboard_employee);
                    t_form_data1.append('user_id', $('#user_id').val());

                    showLoader();

                    $.ajax({
                        url: "{{ url('vmt-employee-onboard') }}",
                        type: "POST",
                        //dataType:"json",
                        contentType: false, //this is requireded please see answers above
                        processData: false,
                        data: t_form_data1,
                        //{
                        // "onboard_type" : t_onboard_type,
                        //    "user_id": $('#user_id').val(),
                        //    "can_onboard_employee" : t_can_onboard_employee,
                        //   "form_data" : t_form_data1.serialize(),
                        //   "_token" : "{{ csrf_token() }}"
                        //}*/,

                        // data:form_data1,
                        // contentType: false,
                        // processData: false,
                        success: function(data) {
                            Swal.fire.close;
                            $('.loader').hide();

                            console.log("Response : " + data.status);
                            console.log(data);
                            $('#modalBody').html('');

                            if (data.status == "success") {
                                $('#modalHeader').html("Success");
                                $('#modalSubHeading').html(data.message);

                                //add the user_id into the hidden field
                                if (data.user_id)
                                    $('#user_id').val(data.user_id);

                                //When submit button clicked, then write a hidden value
                                if (t_can_onboard_employee == "1")
                                    $('#can_redirect').val('1');

                                if (t_can_onboard_employee == "1" && data.mail_status == "success")
                                    $('#SucessMail_send').html("Mail notification sent.");
                                else
                                if (t_can_onboard_employee == "0")
                                    $('#SucessMail_send').html("");
                                else
                                    $('#SucessMail_send').html("Mail notification not sent.");

                                $('#notificationModal').show();
                                $('#notificationModal').removeClass('fade');


                            } else
                            if (data.status == "failure") {
                                $('#modalHeader').html("Error");
                                $('#modalSubHeading').html(data.message);
                                $('#modalBody').html(data.error);
                                $('#notificationModal').show();
                                $('#notificationModal').removeClass('fade');
                            }
                            //console.log(data);

                            //alert(data);
                        },
                        error: function(data) { //NEED TO FIX IT
                            Swal.fire.close;

                            $('.loader').hide();

                            $('#modalHeader').html("Error");
                            $('#modalSubHeading').html(data.message);
                            $('#modalBody').html(data);
                            $('#notificationModal').show();
                            $('#notificationModal').removeClass('fade');

                            console.log("Ajax Error block : " + data);

                        }
                    });

                }

                $('#form-1').validate({
                    // rules: {
                    //     gender: {
                    //         required: true,

                    //     },
                    //     field2: {
                    //         required: true,
                    //         minlength: 5
                    //     }
                    // },
                    // messages: {
                    //     gender: "This is custom error message",
                    // },
                    showErrors: function(errorMap, errorList) {
                        // $("#summary").html("Your form contains "
                        // + this.numberOfInvalids()
                        // + " errors, see details below.");
                        this.defaultShowErrors();
                        // console.log(errorMap);


                        console.log(errorMap);

                        var keys = Object.keys(errorMap);
                        var errors_html = "<ul class='list-style-numbered list-style-circle p-4'>";

                        for (var j = 0; j < keys.length; j++) {
                            //  $('#error-msg').append('<p>&emsp;'+ json_error_fields[keys[j]]+ '</p>');
                            //console.log(keys[j]);
                            errors_html += "<li>" + keys[j] + "</li>";
                        }

                        error_fields = errors_html + "</ul>";

                        //console.log("Inside showErrors");



                    },

                    invalidHandler: function(event, validator) {
                        // 'this' refers to the form
                        var errors = validator.numberOfInvalids();
                        if (errors) {
                            var message = 'You have missed ' + errors +
                                ' field(s). Please check and submit again';
                            console.log(message);
                            //  alert(message);
                        } else {
                            console.log("no errors");

                        }
                    }
                    // errorPlacement: function(error, element) {
                    //     error.text('* ' + error.text());
                    //     if (element.parent('.input-group').length) {
                    //         error.insertAfter(element.parent()); // radio/checkbox?
                    //     } else if (element.hasClass('select2-hidden-accessible')) {
                    //         error.insertAfter(element.next('span')); // select2
                    //         element.next('span').addClass('error').removeClass('valid');
                    //     } else {
                    //         error.insertAfter(element); // default
                    //     }
                    // }
                });

                $("select").on("select2:close", function(e) {
                    $(this).valid();
                });


            });


            var is_core_fields_valid = false;
            var errors_core_fields = [];

            $("#button_close").click(function() {
                console.log("Can re-direct to homepage : " + $('#can_redirect').val());

                if ($('#can_redirect').val() == '1')
                    window.location.href = "/";
            });
        </script>
    @endsection
