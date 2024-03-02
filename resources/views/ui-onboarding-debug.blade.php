{{-- @section('ui-onboarding') --}}
<div class="container-fluid "  style="background-color: blue">
    <div class="">
        <div class="row ">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
                <div class="">
                    <div id="msform">

                        <h1>DEBUG MODE</h1>
                        <form id="form-1" enctype="multipart/form-data" class=" ">
                            @csrf
                            <div class="card shadow  profile-box card-top-border p-2">
                                <div class="card-body justify-content-center align-items-center ">
                                    <div class=" header-card-text">
                                        <h6>Personal Details</h6>
                                    </div>
                                    <div class="form-card">
                                        <div class="row mt-1">
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="employee_code">Employee Code{!! required() !!}</label> -->
                                                <div class="floating">

                                                    <label for="" class="float-label">Employee Code</label>
                                                    <input type="text" placeholder="Employee Code" name="employee_code"
                                                        class="onboard-form form-control textbox" value="{{$empNo}}" required style='text-transform:uppercase'
                                                        @if(!empty($is_employeeCode_editable) && $is_employeeCode_editable == 'false') readonly @endif
                                                    />
                                                    <!-- <label for="" class="float-label">Employee Code</label> -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="employee_name">Employee Name as per Aadhar{!! required() !!}</label> -->

                                                <div class="floating">
                                                    <label for="" class="float-label">Employee Name as per Aadhar <span class="text-danger">*</span></label>
                                                    @if(isset($employee_user->name))
                                                    <input type="text" placeholder="Employee Name as per Aadhar " name="employee_name" id="employee_name" value="Praveen" class="onboard-form form-control textbox capitalize" pattern="name" readonly />
                                                    @else
                                                    <input type="text" placeholder="Employee Name as per Aadhar " name="employee_name" id="employee_name" class=" form-control textbox capitalize" value="Praveen" pattern="name" required  />

                                                    @endif
                                                    <label class="error star_error employee_name_label" for="employee_name" style="display: none;"></label>
                                                    <!-- <label for="" class="float-label">Employee Name as per Aadhar</label> -->
                                                    <!--  <label class="error star_error employee_name_label" for="employee_name"
                                                        style="display: none;"></label> -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="dob">Date of Birth{!! required() !!}</label> -->
                                                @php
                                                $date = (date('Y')-18)."-".date('m')."-".date('d');
                                                @endphp
                                                <div class="floating">
                                                    <label for="" class="float-label">Date of Birth <span class="text-danger">*</span></label>
                                                    <input type="text" value="02/12/2022" placeholder="Date of Birth" name="dob" max="{{$date}}" class="onboard-form form-control textbox" onfocus="(this.type='date')" required />
                                                    <!-- <label for="" class="float-label">Date of Birth</label> -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="marital_status">Marital Status{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Marital Status <span class="text-danger">*</span></label>

                                                    <select placeholder="Marital Status" name="marital_status" id="marital_status" class="onboard-form form-control textbox select2_form_without_search " required>
                                                        <option value="" hidden  disabled>Marital Status</option>
                                                        <option value="unmarried" selected>Unmarried</option>
                                                        <option value="married">Married</option>
                                                        <option value="widowed">Widowed</option>
                                                        <option value="separated">Separated</option>
                                                        <option value="divorced">Divorced</option>
                                                    </select>
                                                    <!-- <label for="" class="float-label">Marital Status</label> -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="doj">Date of Joining{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Date of Joining<span class="text-danger">*</span></label>
                                                    @if(isset($employee_details->doj))
                                                    <input type="text" max="9999-12-31" value="02/12/2022" placeholder="Date of Joining" name="doj" value="{{isset($employee_details->doj)? date("d-m-Y", strtotime($employee_details->doj)) : ''}}" class="onboard-form  form-control textbox "  required readonly />
                                                    @else
                                                    <input type="text" max="9999-12-31" value="02/12/2022"  placeholder="Date of Joining" name="doj" class="onboard-form  form-control textbox " onfocus="(this.type='date')" required />
                                                    @endif
                                                    <!-- <label for="" class="float-label">Date of Joining</label> -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="gender">Gender{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Gender<span class="text-danger">*</span></label>
                                                    <select placeholder="Choose Gender" name="gender" id="gender" class="onboard-form form-control textbox select2_form_without_search " required>
                                                        <option value="" hidden selected disabled>Choose Gender</option>
                                                        <option value="male" selected>Male</option>
                                                        <option value="female">Female</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                    <!-- <label for="" class="float-label">Gender</label> -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="mobile_no">Mobile Number{!! required() !!}</label> -->
                                                <div class="floating">

                                                    <label for="" class="float-label">Mobile Number<span class="text-danger">*</span></label>
                                                    @if(isset($employee_details->mobile_number))
                                                        <input type="text"  placeholder="Mobile Number" name="mobile_no" minlength="10" value="9922002440" maxlength="10" class="onboard-form form-control textbox " required readonly />
                                                    @else
                                                        <input  type="text"  value="9922002440"  placeholder="Mobile Number" name="mobile_no" id="mobile_no" minlength="10" value="" maxlength="10" oninput="numberOnly(this.id);" class="onboard-form form-control textbox " required />
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="email">Email ID{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Email<span class="text-danger">*</span></label>
                                                    <input type="email" pattern="email" placeholder="Email ID" name="email" value="freakz@gmail.com" class="  form-control textbox " onkeypress="return event.charCode != 32" @if(request()->has('email')) readonly @endif required />
                                                    <!-- <label for="" class="float-label">Email</label> -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="aadhar">Aadhaar Number<span id="aadhar_req">{!! required() !!}</span></label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Aadhaar Number<span class="text-danger">*</span></label>
                                                    <input type="text" oninput="numberOnly(this.id);" placeholder="Aadhaar Number" value="223344556666" name="aadhar" id="vmt_aadhar" pattern="aadhar" class="onboard-form form-control textbox " minlength="12" maxlength="12" required />
                                                    {{-- <label class="error star_error aadhar_label" for="aadhar"
                                                        style="display: none;"></label> --}}
                                                    <!-- <label for="" class="float-label">Aadhaar Number</label> -->
                                                </div>
                                                <span class="error" id="error_vmt_aadhar"></span>

                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 co l-lg-3 col-xl-3 mb-2">

                                                <!-- <label class="" for="pan_no">Pan Card Number<span id="pan_no_req">{!! required() !!}</span></label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Pan Number / Pan Acknowlegement<span class="text-danger">*</span></label>
                                                    <input type="text" placeholder="Pan Card Number" name="pan_no" id="pan_num" class=" form-control textbox  pan" value="GGDE234G44" pattern="pan" minlength="10" maxlength="10" required />
                                                    <label class="error star_error pan_no_label" id="pan_no_label" for="pan_no" style="display: none;"></label>

                                                    <span class="error" id="error_pan_no"></span>
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2"> -->
                                                <!-- <label class="" for="pan_ack">Pan Acknowlegement<span id="pan_ack_req">{!! required() !!}</span></label> -->
                                                <!-- <div class="floating">
                                                    <input type="text" placeholder="Pan Acknowlegement" name="pan_ack" pattern="alp-num" minlength="15" maxlength="15" id="pan_ack" class="onboard-form textbox  form-control not-required validate " />
                                                    <label for="" class="float-label">Pan Acknowlegement</label>
                                                </div> -->
                                                <!-- <div class="floating">
                                                    <label for="" class="float-label">Pan Acknowlegement</label>
                                                    <input type="text" placeholder="Pan Acknowlegement " name="pan_ack" id="pan_ack" pattern="alp-num" minlength="15" maxlength="15" class="onboard-form form-control textbox " pattern="name" not-required />
                                                    <label class="error star_error employee_name_label" for="employee_name" style="display: none;"></label>


                                                </div> -->
                                            <!-- </div> -->
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="444">DL Number</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">DL Number</label>
                                                    <input type="text" placeholder="DL Number" name="dl_no" value="Rj1s320120123456" id="dl_no" minlength="16" maxlength="16" class="onboard-form form-control textbox " style='text-transform:uppercase' />
                                                    <label class="error star_error dl_no_label" for="dl_no" style="display: none;"></label>

                                                    <span class="error" id="error_dl_no"></span>
                                                </div>
                                                <!-- <div class="floating">
                                                    <input type="text" placeholder="DL Number" name="dl_no" id="dl_no" minlength="15" maxlength="15"  class="onboard-form form-control textbox" pattern="dl"  required />
                                                    <label class="error star_error employee_name_label" for="employee_name" style="display: none;"></label>
                                                    <label for="" class="float-label">DL Number</label>

                                                </div> -->

                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="nationality">Nationality{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Choose nationality<span class="text-danger">*</span></label>
                                                    <select placeholder="Choose nationality" name="nationality" id="nationality" class="onboard-form form-control textbox  select2_form_without_search" required>
                                                        <option value="" hidden selected disabled>Choose nationality</option>
                                                        <option value="indian" selected>Indian</option>
                                                        <option value="other_country">Other Nationality</option>
                                                    </select>
                                                    <!-- <label for="" class="float-label">Choose nationality</label> -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <div class="floating">
                                                    <label for="" class="float-label">Passport Number</label>
                                                    <input type="text" placeholder="Passport Number" name="passport_no" id="passport_no" minlength="8" maxlength="8" value="24422333" class="form-control textbox" style='text-transform:uppercase' required/>
                                                    <label class="error star_error passport_no_label" for="passport_no" style="display: none;"></label>

                                                    <span class="error" id="error_passport_no"></span>
                                                </div>

                                                <!-- <div class="floating">
                                                <input type="text" placeholder="Passport Number" name="passport_no" id="passport_no" minlength="8" maxlength="8" class="onboard-form form-control textbox  not-required validate" />
                                                    <label class="error star_error passport_no_label" for="passport_no" style="display: none;"></label>
                                                    <label for="" class="float-label">Passport Number</label>
                                                    <span class="error" id="error_passport_no"></span>

                                                </div> -->

                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="passport_exp">Passport Exp Date<span id="passport_exp_req">{!! required() !!}</span></label> -->
                                                <!-- <div class="floating">
                                                    <input type="text" max="9999-12-31" placeholder="Passport Exp Date" name="passport_exp" min="{{date('Y-m-d')}}" id="passport_exp" onfocus="(this.type='date')" class="onboard-form form-control textbox  not-required validate" />
                                                    <label for="" class="float-label">Passport Exp Date</label>
                                                </div> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Passport Exp Date</label>
                                                    <input type="text" max="9999-12-31" placeholder="Date of Joining" name="exp" class="onboard-form  form-control textbox " value="9999-12-31" id="passdate" onfocus="(this.type='date')" required />
                                                    <!-- <label for="" class="float-label">Passport Exp Date</label> -->
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="blood_group">Blood Group</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Blood Group</label>
                                                    <select placeholder="Blood Group" name="blood_group" id="blood_group" class="onboard-form form-control textbox   select2_form_without_search">
                                                        <option value="" hidden selected disabled>Select Blood Group</option>
                                                        <option value="a-positive" selected>A Positive</option>
                                                        <option value="a-negative">A Negative</option>
                                                        <option value="b-positive">B Positive</option>
                                                        <option value="b-negative">B Negative</option>
                                                        <option value="ab-positive">AB Positive</option>
                                                        <option value="ab-negative">AB Negative</option>
                                                        <option value="o-positive">O Positive</option>
                                                        <option value="o-negative">O Negative</option>
                                                    </select>
                                                    <!-- <label for="" class="float-label">Blood Group</label> -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="physically_challenged">Physically Challenged</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Physically Challenged</label>
                                                    <select placeholder="Physically Challenged" name="physically_challenged" class="onboard-form form-control textbox  select2_form_without_search" required>
                                                        <option value="" hidden selected disabled>Physically Challenged</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no" selected>No</option>
                                                    </select>
                                                    <!-- <label for="" class="float-label">Physically Challenged</label> -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">

                                                <!-- <label class="" for="bank_name">Bank Name</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Bank Name<span class="text-danger">*</span></label>
                                                    <select placeholder="Bank Name" name="bank_name" id="bank_names" class="onboard-form form-control textbox  select2_form_without_search" required>
                                                        <option value="" hidden selected disabled>Select Bank Name</option>
                                                        @foreach($bank as $b)
                                                        <!-- <option value="{{$b->bank_name}}" min-data="{{$b->min_length}}" max-data="{{$b->max_length}}">{{$b->bank_name}}</option> -->

                                                        <option value="HDFC" selected>HDFC</option>
                                                        @endforeach
                                                    </select>
                                                    <!-- <label for="" class="float-label">Bank Name</label> -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <div class="floating">
                                                    <!-- <label class="" for="account_no">Account Number</label> -->
                                                    <label for="" class="float-label">Account Number<span class="text-danger">*</span></label>

                                                    <input type="text" placeholder="Account Number" name="account_no" value="34532245667799" id="account_no" class="onboard-form form-control textbox " oninput="numberOnly(this.id);"  minlength="10" maxlength="18" required />
                                                    <label class="error star_error account_no_label" for="account_no" style="display: none;"></label>
                                                    <!-- <label for="" class="float-label">Account Number</label> -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="bank_ifsc">Bank IFSC Code</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Bank IFSC Code<span class="text-danger">*</span></label>
                                                    <input type="text" placeholder="Bank IFSC Code" name="bank_ifsc" id="bank_ifsc" value="HDFC2345" pattern="ifsc" class=" form-control textbox " required />
                                                    <label class="error star_error bank_ifsc_label" for="bank_ifsc" style="display: none;"></label>
                                                    <!-- <label for="" class="float-label">Bank IFSC Code</label> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow  profile-box card-top-border p-2">
                                <div class="card-body justify-content-center align-items-center">
                                    <div class="form-card">
                                        <div class=" header-card-text">
                                            <h6>Statutory Details</h6>
                                        </div>
                                        <div class="row ">
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <div class="floating">
                                                    <label for="" class="float-label">PF Applicable</label>

                                                    <select placeholder="PF Applicable" name="pf_applicable" id="pf_applicable" class="onboard-form form-control textbox  select2_form_without_search" required>
                                                        <!-- <option value="" hidden selected disabled>PF Applicable</option> -->
                                                        <option value="Yes">Yes</option>
                                                        <option value="No" selected>No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <div class="floating">
                                                    <label for="" class="float-label">EPF Number</label>
                                                    <input type="text" placeholder="EPF Number" name="epf_number" id="epf_number" value="TN MAS 054110 000 0054321" class="onboard-form form-control textbox " />

                                                    <span class="error" id="error_epf_number"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">

                                                <div class="floating">
                                                    <label for="" class="float-label">UAN Number</label>
                                                    <input type="text" placeholder="UAN Number" name="uan_number" value="FGTF12455" id="uan_number" minlength="12" maxlength="12" class="onboard-form form-control textbox "/>

                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <div class="floating">
                                                    <label for="" class="float-label">ESIC Applicable</label>
                                                    <select placeholder="ESIC Applicable" name="esic_applicable" id="esic_applicable" class="onboard-form form-control textbox  select2_form_without_search" required>
                                                        <!-- <option value="" hidden selected disabled>ESIC Applicable</option> -->
                                                        <option value="Yes">Yes</option>
                                                        <option value="No" selected>No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6 col-lg-3 col-xl-3 mb-2">
                                                <div class="floating">
                                                    <label for="" class="float-label">ESIC Number</label>

                                                    <input type="text" placeholder="ESIC Number" name="esic_number" value="31–00–123456–000–0000" id="esic_number" minlength="10" maxlength="10" class="onboard-form form-control textbox " />
                                                    <span class="error" id="error_esic_number"></span>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-6 col-lg-3 col-xl-3 mb-2">
                                                <div class="floating">
                                                    <label for="" class="float-label">Ptax Location</label>

                                                    <select placeholder="Ptax Location" value name="ptax_location" id="" class="onboard-form form-control textbox  select2_form_without_search">
                                                        <option value="Chennai" hidden selected disabled>Chennai</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6 col-lg-3 col-xl-3 mb-2">
                                                <div class="floating">
                                                    <label for="" class="float-label">TAX Regime</label>
                                                    <select placeholder="TAX Regime" name="tax_regime" id="tax_regime" class="onboard-form form-control textbox  select2_form_without_search" required>
                                                        <!-- <option value="" hidden selected disabled>TAX Regime</option> -->
                                                        <option value="Old">Old</option>
                                                        <option value="New" selected> New</option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <div class="floating">
                                                    <label for="" class="float-label">LWF Location</label>
                                                    <select placeholder="LWF Location" name="lwf_location" id="" class="onboard-form form-control textbox  select2_form_without_search">
                                                        <!-- <option value="" hidden selected disabled>LWF Location</option> -->
                                                        <option value="Yes">Yes</option>
                                                        <option value="No" selected>Trichy</option>
                                                    </select>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- address details -->

                            <div class="card shadow  profile-box card-top-border p-2">
                                <div class="card-body justify-content-center align-items-center">
                                    <div class="form-card">
                                        <div class=" header-card-text">
                                            <h6>Current Address</h6>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-6 col-sm-12 col-xs-6 col-lg-6 col-xxl-6 mb-2">
                                                <!-- <label class="" for="current_address">Current Address{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Address 1<span class="text-danger">*</span></label>

                                                    <textarea placeholder="Current Address" name="current_address_line_1" id="current_address_line_1" class=" form-control textbox capitalize" required id="" cols="" rows="1">no.21 mgr nagar,t.nagar
                                                    </textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-6 col-lg-6 col-xxl-6 mb-2">
                                                <!-- <label class="" for="current_address">Current Address{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Address 2</label>

                                                    <textarea placeholder="Current Address" name="current_address_line_2" id="current_address_line_2" class="form-control textbox capitalize" required id="" cols="" rows="1">no.21 mgr nagar,t.nagar</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <input type="text" placeholder="" name="curent_district" class="onboard-form form-control textbox " required /> -->
                                                <!-- <label class="" for="curent_district">Country{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Country<span class="text-danger">*</span></label>
                                                    <select placeholder="Country" name="current_district" id="" class="onboard-form form-control textbox  select2_form_without_search" required>
                                                        <!-- <option value="" hidden selected disabled>Select Country</option> -->
                                                        @foreach($countries as $data)
                                                        <!-- <option value="{{$data->country_code}}">{{$data->country_name}}
                                                        </option> -->
                                                        @endforeach
                                                        <option value="india"  selected >India</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="current_state">Current State{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">State<span class="text-danger">*</span></label>
                                                    <select placeholder="State" name="current_state" id="" class="onboard-form form-control textbox  select2_form_without_search" required>
                                                        <!-- <option value="" hidden selected disabled>Select State</option> -->
                                                        <option value="Tamil Nadu" selected>Tamil Nadu</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="current_city">Current City{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label"> City<span class="text-danger">*</span></label>
                                                    <input type="text" placeholder="City" value="Chennai" name="current_city" id="current_city" class="onboard-form form-control textbox  capitalize" required />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="current_pincode">Current Pincode{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Pincode<span class="text-danger">*</span></label>

                                                    <input type="text" minlength="6" maxlength="6" value="600042" oninput="numberOnly(this.id);" placeholder="Pincode" name="current_pincode" id="current_pincode" class="onboard-form form-control textbox " required />
                                                </div>
                                            </div>


                                        </div>
                                        {{-- copy address --}}
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 my-3">

                                                <input type="checkbox" placeholder="" name="current_address_copy" id="current_address_copy" style="width:auto;" />
                                                <label for="current_address_copy">Copy current address to the
                                                    permanent address</label>


                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12 ">
                                                <h6>Permanent Address</h6>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-6 col-lg-6 col-xxl-6 mb-2">
                                                <!-- <label class="" for="permanent_address">Permanent Address{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label"> Address 1 <span class="text-danger">*</span></label>
                                                    <textarea placeholder="Permanent Address" name="permanent_address_line_1" id="permanent_address_line_1" class="form-control textbox capitalize" required cols="5" rows="1">no.21 mgr nagar,t.nagar</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-6 col-lg-6 col-xxl-6 mb-2">
                                                <!-- <label class="" for="permanent_address">Permanent Address{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label"> Address 2</label>
                                                    <textarea placeholder="Permanent Address" name="permanent_address_line_2" id="permanent_address_line_2" class="form-control textbox capitalize" required cols="5" rows="1">no.21 mgr nagar,t.nagar</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 col-xxl-3 mb-2">
                                                <!-- <input type="text" placeholder="" name="permanent_district" class="onboard-form form-control textbox " required /> -->
                                                <!-- <label class="" for="permanent_district">Permanent Country{!! required() !!}</label> -->

                                                <div class="floating">
                                                    <label for="" class="float-label">Country <span class="text-danger">*</span></label>

                                                    <select placeholder="Permanent Country" name="permanent_district" id="" class="onboard-form form-control textbox  select2_form_without_search" required>
                                                        <!-- <option value="" hidden selected disabled>Select Country</option>
                                                        @foreach($countries as $data)
                                                        <option value="{{$data->country_code}}">{{$data->country_name}}
                                                        </option>
                                                        @endforeach -->
                                                        <option value="India" selected>India</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="permanent_state">Permanent State{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label"> State<span class="text-danger">*</span></label>

                                                    <select placeholder="Permanent State" name="permanent_state" id="" class="onboard-form form-control textbox  select2_form_without_search" required>
                                                        <option value="Tamil Nadu" selected>Tamil Nadu</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3  col-xxl-3 mb-2">
                                                <!-- <label class="" for="permanent_city">Permanent City{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label"> City<span class="text-danger">*</span></label>

                                                    <input type="text" placeholder=" City" value="Chennai" name="permanent_city" id="permanent_city" class="onboard-form form-control textbox capitalize" required />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="permanent_pincode">Permanent Pincode{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label"> Pincode <span class="text-danger">*</span></label>

                                                    <input type="text" placeholder=" Pincode" value="600042" name="permanent_pincode" id="permanent_pincode" oninput="numberOnly(this.id);" minlength="6" maxlength="6" class="onboard-form form-control textbox " required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow  profile-box card-top-border p-2">
                                <div class="card-body justify-content-center align-items-center ">
                                    <div class="header-card-text">
                                        <h6 class="">Official Details</h6>
                                    </div>
                                    <div class="form-card">
                                        <div class="row mt-1">
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 col-xxl-3 mb-2">
                                                <!-- <label class="" for="department">Department{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Department</label>

                                                    <select placeholder="Department" name="" id="" class=" form-control textbox">
                                                    <option value="IT" selected> IT</option>    
                                                  
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 col-xxl-3 mb-2">
                                                <!-- <label class="" for="process">Process{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Process</label>
                                                    <input type="text" placeholder="Process"  value="frontend senior" name="process" class="onboard-form form-control" pattern="name" required />

                                               </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 col-xxl-3 mb-2">
                                                <!-- <label class="" for="designation">Designation{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Designation<span class="text-danger">*</span> </label>

                                                    <input type="text" placeholder="Designation" value="frontend" name="designation" class=" form-control textbox " pattern="alpha" required />
                                                    <label class="error star_error designation_label" for="designation" style="display: none;"></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="cost_center">Cost Center{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Cost Center</label>

                                                    <input type="number" placeholder="Cost Center" value="444" name="cost_center" class="onboard-form form-control textbox " />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="confirmation_period">Probabition Period{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Probation Period</label>

                                                    <select placeholder="Probabition Period" name="confirmation_period" class="onboard-form form-control textbox  not-required validate select2_form_without_search">
                                                        <option value="" hidden selected disabled>Select Probabition Period</option>
                                                        <option value="1" selected>1 Month</option>
                                                        <option value="2">2 Month</option>
                                                        <option value="3">3 Month</option>
                                                        <option value="4">4 Month</option>
                                                        <option value="5">5 Month</option>
                                                        <option value="6">6 Month</option>
                                                        <option value="7">7 Month</option>
                                                        <option value="8">8 Month</option>
                                                        <option value="9">9 Month</option>
                                                        <option value="10">10 Month</option>
                                                        <option value="11">11 Month</option>
                                                        <option value="12">12 Month</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2 col-xl-3">
                                                <!-- <label class="" for="work_location">Work Location{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Work Location<span class="text-danger">*</span></label>
                                                    <input type="text" value="Chennai" placeholder="Work Location" name="work_location" class="onboard-form form-control textbox capitalize" pattern="alpha" required />
                                                    <label class="error star_error work_location_label" for="work_location" style="display: none;"></label>

                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2 col-xxl-3">
                                                <!-- <label class="" for="l1_manager_code">Reporting Manager Employee Code{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Reporting Manager Code<span class="text-danger">*</span></label>

                                                    @if (isset($emp_office_details->l1_manager_code))
                                                        <input type="text" value="Emp100" name="l1_manager_code" id="l1_manager_code" class="form-control textbox " pattern="" readonly />
                                                    @else
                                                        <select placeholder="Reporting Manager" name="l1_manager_code" id="" class=" form-control  textbox ">
                                                            <option value="Praveen" selected>Praveen</option>
                                                            <!-- <option value="" hidden selected disabled>Select</option>
                                                            @foreach($allEmployeesUserCode as $e)
                                                                 <option value="{{$e->user_code}}">{{$e->user_code}}</option>
                                                            @endforeach -->
                                                        </select>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2 col-xxl-3">

                                                <div class="floating">
                                                    <label for="" class="float-label">Reporting Manager Name</label>
                                                    <input type="text" placeholder="Reporting Manager Name" name="l1_manager_name" id="" class="textbox  onboard-form form-control " pattern="name" value="Sirini" readonly/>
                                                    <label class="error star_error l1_manager_name_label" for="l1_manager_name" style="display: none;"></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <div class="floating">
                                                    <label for="" class="float-label">Holiday Location</label>
                                                    <select placeholder="Holiday Location" name="holiday_location" id="holiday_location" class="textbox  onboard-form form-control  select2_form_without_search" required>
                                                        <option value="" hidden selected disabled>Holiday Location</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="officical_mail">Official E-Mail Id{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Official Email </label>
                                                    <input type="email" placeholder="Official E-Mail Id" name="officical_mail" value="praveen@gamil.com" class="textbox form-control " pattern="email" onkeypress="return event.charCode != 32"/>
                                                    <!--  <label class="error star_error officical_mail_label" for="officical_mail" style="display: none;"></label> -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="official_mobile">Official Mobile{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Official Mobile</label>
                                                    <input type="text" minlength="10" maxlength="10" value="9988776644" placeholder="Official Mobile" name="official_mobile" id="official_mobile" oninput="numberOnly(this.id);" class="textbox  onboard-form form-control " />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="emp_notice">Employee Notice Period Days{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Employee Notice Period Days</label>
                                                    <input type="number" placeholder="Employee Notice Period Days" name="emp_notice" value="10" class="onboard-form form-control textbox " />
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <div class="floating">
                                                    <label for="" class="float-label">Date of confirmation<span class="text-danger">*</span></label>
                                                    <input type="text" max="9999-12-31" placeholder="Date of confirmation" name="dow" value="9999-12-31" class="onboard-form form-control textbox " onfocus="(this.type='date')" required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card shadow  profile-box card-top-border p-2">
                                <div class="card-body justify-content-center align-items-center ">
                                    <div class="header-card-text">
                                        <h6 class="mb-0">Family Details</h6>
                                    </div>
                                    <div class="form-card">
                                        <div class="row mt-1">
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="father_name">Father Name{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Father Name <span class="text-danger">*</span></label>

                                                    <input type="text" placeholder="Father Name" name="father_name" pattern="name" class="onboard-form form-control textbox capitalize" required  value="Joe"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <div class="floating">
                                                    <label for="" class="float-label">Date of Birth <span class="text-danger">*</span></label>

                                                    <input type="text" max="9999-12-31" placeholder="Date of Birth" value="9999-12-31" name="dob_father" id="dob_father" class="onboard-form form-control textbox  " onfocus="(this.type='date')" required />
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <div class="floating">
                                                    <label for="" class="float-label">Gender</label>

                                                    <!-- <select placeholder="Gender" name="father_gender" id="father_gender" class="textbox  onboard-form form-control   select2_form_without_search" required>
                                                        <option value="" hidden selected disabled>Gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>

                                                    </select> -->
                                                    <input type="text" class="form-control" name="Male" id="" value="Male" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="father_name">Father Name{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Age </label>

                                                    <input type="number" placeholder="Age" value="55" name="father_age" id="father_age" class="textbox  onboard-form form-control " minlength="2" maxlength="3" readonly/>
                                                </div>
                                            </div>


                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="mother_name">Mother Name{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Mother Name <span class="text-danger">*</span></label>

                                                    <input type="text" placeholder="Mother Name" value="Rose" name="mother_name" pattern="name" class="textbox  onboard-form form-control capitalize" required />
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <div class="floating">
                                                    <label for="" class="float-label">Date of Birth <span class="text-danger">*</span></label>

                                                    <input type="text" max="9999-12-31" value="9999-12-31" placeholder="Date of Birth" name="dob_mother" id="dob_mother" class="textbox  onboard-form form-control " onfocus="(this.type='date')" required />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <div class="floating">
                                                    <label for="" class="float-label">Gender</label>

                                                    <!-- <select placeholder="Gender" name="mother_gender" id="mother_gender" class="textbox  onboard-form form-control   select2_form_without_search" required>
                                                        <option value="" hidden selected disabled>Gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select> -->
                                                    <input type="text" class="form-control" name="Male" id="" value="Female" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="father_name">Father Name{!! required() !!}</label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Age</label>

                                                    <input type="number" placeholder="Age" value="50" name="mother_age" id="mother_age" class="textbox  onboard-form form-control " minlength="2" maxlength="3" readonly/>
                                                </div>
                                            </div>



                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="spouse_name">Spouse Name<span id="spouse_name_req">{!! required() !!}</span></label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Spouse Name <span class="text-danger">*</span></label>

                                                    <input type="text" value="Ray" placeholder="Spouse Name" name="spouse_name" pattern="name" class="textbox  onboard-form form-control  spouse_data capitalize" required />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="dow">Date of Wedding<span id="dow_req">{!! required() !!}</span></label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Date of Wedding <span class="text-danger">*</span></label>

                                                    <input type="text" value="1999-02-11" max="9999-12-31" placeholder="Date of Wedding" name="dow" class="textbox  onboard-form form-control  spouse_data" onfocus="(this.type='date')" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="spouse_gender">Spouse Gender<span id="spouse_gender_req">{!! required() !!}</span></label> -->

                                                <div class="floating">
                                                    <label for="" class="float-label">Gender <span class="text-danger">*</span></label>

                                                    <select placeholder="Spouse Gender" name="spouse_gender" id="spouse_gender" class="textbox  onboard-form form-control  spouse_data select2_form_without_search" required>
                                                        <!-- <option value="" hidden selected disabled>Select Spouse Gender</option> -->
                                                        <!-- <option value="male">Male</option> -->
                                                        <option value="female" selected>Female</option>
                                                        <!-- <option value="other">Other</option> -->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="spouse_dob">Spouse DOB<span id="spouse_dob_req">{!! required() !!}</span></label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Spouse DOB <span class="text-danger">*</span></label>

                                                    <input type="text" max="9999-12-31" value="9999-12-31" placeholder="Spouse DOB" name="spouse_dob" class="textbox  onboard-form form-control  spouse_data" onfocus="(this.type='date')" required />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="no_child">Number of Children<span id="no_child_req">{!! required() !!}</span></label> -->
                                                <div class="floating">
                                                    <label for="" class="float-label">Number of Children</label>

                                                    <select placeholder="Number of Children" name="no_of_child" id="no_of_child" class="textbox onboard-form form-control  spouse_data select2_form_without_search">
                                                        <!-- <option value="" hidden selected disabled>Select Number of Children</option>
                                                        <option value="0">0</option> -->
                                                        <option value="1" selected>1</option>
                                                        <!-- <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option> -->
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow  profile-box card-top-border p-2">
                                <div class="card-body justify-content-center align-items-center">
                                    <div class="header-card-text">
                                        <h6>Compensatory</h6>
                                    </div>
                                    <div class="form-card">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="basic">Basic Salary{!! required() !!}</label> -->

                                                @if(isset($compensatory->basic))

                                                <div class="floating">

                                                    <label for="" class="float-label">Basic Salary</label>
                                                    <input type="number" placeholder="Basic Salary" name="basic" value="88999" class="textbox   onboard-form form-control  calculation_data gross_data" step="0.01" readonly />
                                                </div>
                                                @else
                                                <div class="floating">
                                                    <label for="" class="float-label">Basic Salary</label>
                                                    <input type="number" placeholder="Basic Salary" name="basic" value="88999" class="onboard-form form-control textbox  calculation_data gross_data  " step="0.01" required />
                                                </div>
                                                @endif

                                            </div>

                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="hra">HRA{!! required() !!}</label> -->

                                                @if(isset($compensatory->hra))

                                                <div class="floating">
                                                    <label for="" class="float-label">HRA</label>

                                                    <input type="number" placeholder="HRA" name="hra" value="333" class="onboard-form form-control textbox   calculation_data gross_data " step="0.01" readonly />
                                                </div>
                                                @else
                                                <div class="floating">
                                                    <label for="" class="float-label">HRA</label>
                                                    <input type="number" placeholder="HRA" name="hra" value="333" class="textbox  onboard-form form-control textbox    calculation_data gross_data" step="0.01" />
                                                </div>

                                                @endif
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="Statutory_bonus">Statutory Bonus{!! required() !!}</label> -->

                                                @if(isset($compensatory->Statutory_bonus))

                                                <div class="floating">
                                                    <label for="" class="float-label">Statutory Bonus</label>
                                                    <input type="number" placeholder="Statutory Bonus"  name="statutory_bonus" value="500" class="onboard-form form-control textbox   calculation_data gross_data" step="0.01" readonly />
                                                </div>
                                                @else
                                                <div class="floating">
                                                    <label for="" class="float-label">Statutory Bonus</label>
                                                    <input type="number" placeholder="Statutory Bonus" name="statutory_bonus" value="500" class="textbox onboard-form form-control  calculation_data gross_data" step="0.01" />
                                                </div>
                                                @endif

                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="child_education_allowance">Child Education Allowance{!! required() !!}</label> -->

                                                @if(isset($compensatory->child_education_allowance))

                                                <div class="floating">
                                                    <label for="" class="float-label">Child Education Allowance</label>
                                                    <input type="number" placeholder="Child Education Allowance" name="child_education_allowance" value="50000" class="onboard-form form-control textbox   calculation_data gross_data" step="0.01" readonly />
                                                </div>
                                                @else
                                                <div class="floating">
                                                    <label for="" class="float-label">Child Education Allowance</label>
                                                    <input type="number" placeholder="Child Education Allowance" name="child_education_allowance" value="50000" class="onboard-form form-control  calculation_data textbox  gross_data" step="0.01" />
                                                </div>
                                                @endif


                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="food_coupon">Food Coupon{!! required() !!}</label> -->

                                                @if(isset($compensatory->food_coupon))

                                                <div class="floating">
                                                    <label for="" class="float-label">Food Coupon</label>
                                                    <input type="number" placeholder="Food Coupon" name="food_coupon" value="44555" class="onboard-form form-control textbox  calculation_data gross_data" step="0.01" readonly />
                                                </div>
                                                @else
                                                <div class="floating">
                                                    <label for="" class="float-label">Food Coupon</label>
                                                    <input type="number" placeholder="Food Coupon" name="food_coupon" value="44555" class="textbox  onboard-form form-control  calculation_data gross_data" step="0.01" />
                                                </div>
                                                @endif

                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="lta">LTA{!! required() !!}</label> -->

                                                @if(isset($compensatory->lta))

                                                <div class="floating">
                                                    <label for="" class="float-label">LTA</label>
                                                    <input type="number" placeholder="LTA" name="lta" value="9900" class="textbox onboard-form form-control     calculation_data gross_data" step="0.01" readonly />
                                                </div>
                                                @else
                                                <div class="floating">
                                                    <label for="" class="float-label">LTA</label>
                                                    <input type="number" placeholder="LTA" name="lta" value="9900" class="onboard-form form-control textbox   calculation_data gross_data" step="0.01" />
                                                </div>
                                                @endif

                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="special_allowance">Special Allowance{!! required() !!}</label> -->

                                                @if(isset($compensatory->special_allowance))

                                                <div class="floating">
                                                    <label for="" class="float-label">Special Allowance</label>
                                                    <input type="number" placeholder="Special Allowance" value="888" name="special_allowance"  class="onboard-form form-control textbox   calculation_data gross_data" step="0.01" readonly />
                                                </div>
                                                @else
                                                <div class="floating">
                                                    <label for="" class="float-label">Special Allowance</label>
                                                    <input type="number" placeholder="Special Allowance" value="888" name="special_allowance" class="textbox  onboard-form form-control  calculation_data gross_data" step="0.01" />
                                                </div>
                                                @endif

                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="other_allowance">Other Allowance{!! required() !!}</label> -->

                                                @if(isset($compensatory->other_allowance))

                                                <div class="floating">
                                                    <label for="" class="float-label">Other Allowance</label>

                                                    <input type="number" placeholder="Other Allowance" name="other_allowance" value="44" class="textbox  onboard-form form-control  calculation_data gross_data" step="0.01" readonly />
                                                </div>
                                                @else
                                                <div class="floating">
                                                    <label for="" class="float-label">Other Allowance</label>
                                                    <input type="number" placeholder="Other Allowance" name="other_allowance" value="44" class="textbox  onboard-form form-control  calculation_data gross_data" step="0.01" />
                                                </div>
                                                @endif

                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="gross">Gross Salary{!! required() !!}</label> -->

                                                @if(isset($compensatory->gross))

                                                <div class="floating">
                                                    <label for="" class="float-label">Gross Salary</label>

                                                    <input type="number" placeholder="Gross Salary" name="gross" value="33" class="textbox  onboard-form form-control " step="0.01" required readonly />
                                                </div>
                                                @else
                                                <div class="floating">
                                                    <label for="" class="float-label">Gross Salary</label>

                                                    <input type="number" placeholder="Gross Salary" name="gross" id="gross" value="33" class="textbox  onboard-form form-control " step="0.01" required readOnly />
                                                </div>
                                                @endif

                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="epf_employer_contribution">EPF employer contribution{!! required() !!}</label> -->

                                                @if(isset($compensatory->epf_employer_contribution))

                                                <div class="floating">
                                                    <label for="" class="float-label">EPF employer contribution</label>

                                                    <input type="number" placeholder="EPF employer contribution" name="epf_employer_contribution" value="33" class="textbox   onboard-form form-control  calculation_data cic_data" step="0.01" readonly />
                                                </div>
                                                @else
                                                <div class="floating">
                                                    <label for="" class="float-label">EPF employer contribution</label>
                                                    <input type="number" placeholder="EPF employer contribution" name="epf_employer_contribution" value="33" class="onboard-form form-control  calculation_data cic_data textbox " step="0.01" />
                                                </div>
                                                @endif


                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="esic_employer_contribution">ESIC employer contribution{!! required() !!}</label> -->

                                                @if(isset($compensatory->esic_employer_contribution))

                                                <div class="floating">
                                                    <label for="" class="float-label">ESIC employer contribution</label>
                                                    <input type="number" placeholder="ESIC employer contribution" name="esic_employer_contribution" value="100" class="onboard-form form-control textbox   calculation_data cic_data" step="0.01" readonly />
                                                </div>
                                                @else
                                                <div class="floating">
                                                    <label for="" class="float-label">ESIC employer contribution</label>
                                                    <input type="number" placeholder="ESIC employer contribution" name="esic_employer_contribution" value="100" class="onboard-form form-control textbox  calculation_data cic_data" step="0.01" />
                                                </div>
                                                @endif

                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="insurance">Insurance{!! required() !!}</label> -->

                                                @if(isset($compensatory->insurance))

                                                <div class="floating">
                                                    <label for="" class="float-label">Insurance</label>
                                                    <input type="number" placeholder="Insurance" name="insurance" value="666" class="onboard-form form-control textbox   calculation_data cic_data" step="0.01" readonly />
                                                </div>
                                                @else
                                                <div class="floating">
                                                    <label for="" class="float-label">Insurance</label>
                                                    <input type="number" placeholder="Insurance" name="insurance" value="666" class="onboard-form form-control textbox  calculation_data cic_data" step="0.01" />
                                                </div>
                                                @endif

                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="graduity">Graduity{!! required() !!}</label> -->

                                                @if(isset($compensatory->graduity))

                                                <div class="floating">
                                                    <label for="" class="float-label">Graduity</label>
                                                    <input type="number" placeholder="Graduity" name="graduity" value="455" class="onboard-form form-control textbox   calculation_data cic_data" step="0.01" readonly />
                                                </div>
                                                @else
                                                <div class="floating">
                                                    <label for="" class="float-label">Graduity</label>
                                                    <input type="number" placeholder="Graduity" name="graduity" value="455" class="onboard-form form-control textbox   calculation_data cic_data" step="0.01" />
                                                </div>
                                                @endif

                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="cic">Cost of Company{!! required() !!}</label> -->

                                                @if(isset($compensatory->cic))

                                                <div class="floating">
                                                    <label for="" class="float-label">Cost of Company</label>

                                                    <input type="number" placeholder="Cost of Company" name="cic" value="444" id="cic" class="onboard-form form-control textbox " step="0.01" required readonly />
                                                </div>
                                                @else
                                                <div class="floating">
                                                    <label for="" class="float-label">Cost of Company</label>

                                                    <input type="number" placeholder="Cost of Company" name="cic" value="444" id="cic" class="onboard-form form-control textbox " step="0.01" required readOnly />
                                                </div>
                                                @endif

                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="epf_employee">EPF Employee{!! required() !!}</label> -->

                                                @if(isset($compensatory->epf_employee))

                                                <div class="floating">
                                                    <label for="" class="float-label">EPF Employee</label>

                                                    <input type="number" placeholder="EPF Employee" name="epf_employee" value="5555" class="onboard-form form-control  calculation_data net_data textbox " step="0.01" readonly />
                                                </div>
                                                @else
                                                <div class="floating">
                                                    <label for="" class="float-label">EPF Employee</label>

                                                    <input type="number" placeholder="EPF Employee" name="epf_employee" value="5555" class="onboard-form form-control  calculation_data net_data textbox " step="0.01" />
                                                </div>
                                                @endif

                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="esic_employee">ESIC Employee{!! required() !!}</label> -->

                                                @if(isset($compensatory->esic_employee))

                                                <div class="floating">
                                                    <label for="" class="float-label">ESIC Employee</label>

                                                    <input type="number" placeholder="ESIC Employee" name="esic_employee" value="998" class="textbox  onboard-form form-control  calculation_data net_data" step="0.01" readonly />
                                                </div>
                                                @else
                                                <div class="floating">
                                                    <label for="" class="float-label">ESIC Employee</label>

                                                    <input type="number" placeholder="ESIC Employee" name="esic_employee" value="998" class="textbox  onboard-form form-control  calculation_data net_data" step="0.01" />
                                                </div>
                                                @endif

                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="professional_tax">Professional Tax{!! required() !!}</label> -->

                                                @if(isset($compensatory->professional_tax))

                                                <div class="floating">
                                                    <label for="" class="float-label">Professional Tax</label>

                                                    <input type="number" placeholder="Professional Tax" name="professional_tax" value="1000" class="textbox  onboard-form form-control  calculation_data net_data " step="0.01" readonly />
                                                </div>
                                                @else
                                                <div class="floating">
                                                    <label for="" class="float-label">Professional Tax</label>

                                                    <input type="number" placeholder="Professional Tax" name="professional_tax" value="1000" class="textbox  onboard-form form-control calculation_data net_data " step="0.01" />
                                                </div>

                                                @endif

                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="labour_welfare_fund">labour welfare fund{!! required() !!}</label> -->

                                                @if(isset($compensatory->labour_welfare_fund))

                                                <div class="floating">
                                                    <label for="" class="float-label">labour welfare fund</label>

                                                    <input type="number" placeholder="labour welfare fund" name="labour_welfare_fund" value="909" class="onboard-form form-control calculation_data net_data textbox " step="0.01" readonly />
                                                </div>
                                                @else
                                                <div class="floating">
                                                    <label for="" class="float-label">labour welfare fund</label>

                                                    <input type="number" placeholder="labour welfare fund" name="labour_welfare_fund" value="909"class="onboard-form form-control calculation_data net_data textbox  " step="0.01" />
                                                </div>
                                                @endif

                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-3 col-xl-3 mb-2">
                                                <!-- <label class="" for="net_income">Net Income{!! required() !!}</label> -->

                                                @if(isset($compensatory->net_income))

                                                <div class="floating">
                                                    <label for="" class="float-label">Net Income</label>

                                                    <input type="number" placeholder="Net Income" name="net_income" value="{{$compensatory->net_income? $compensatory->net_income : '0'}}" class="onboard-form form-control textbox " step="0.01" required readonly />
                                                </div>
                                                @else
                                                <div class="floating">
                                                    <label for="" class="float-label">Net Income</label>

                                                    <input type="number" placeholder="Net Income" name="net_income" id="net_income" class="onboard-form form-control textbox " step="0.01" required readOnly />
                                                </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow  profile-box card-top-border p-2">
                                <div class="card-body justify-content-center align-items-center ">
                                    <div class="header-card-text">
                                        <h6 class="mb-0">Personal Documents</h6>
                                    </div>
                                    <div class="form-card mb-2">
                                        <div class="row mt-1">
                                            <!-- <div class="col-12 mb-2">
                                                    <input type="checkbox" placeholder="" name="aadhar_backend"
                                                        id="aadhar_backend" style="width:auto;" />
                                                    <label for="aadhar_backend">Upload aadhar backend</label>
                                                </div> -->
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6 mb-2">
                                                <!-- <label class="" for="aadhar_card">Aadhar Card{!! required() !!}</label> -->
                                                <label for="" class="float-label">Aadhar
                                                    Card Front<span class="text-danger">*</span></label>
                                                <div class="addfiles form-control md" data="#aadhar_card_file" id="aadhar_card_file_label"><span class="file_label">Choose Aadhar
                                                        Card Front</span></div>
                                                <input type="file" accept="image/png, image/gif, image/jpeg" style="display:none;" placeholder="Aadhar Card" name="aadhar_card_file" id="aadhar_card_file" class="onboard-form form-control files" required />
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6 mb-2" id="aadhar_card_backend_content">
                                                <!-- <label class="" for="aadhar_card_backend">Aadhar Card Backend<span id="aadhar_card_backend_req">{!! required() !!}</span></label> -->
                                                <label for="" class="float-label"> Aadhar Card Back<span class="text-danger">*</span></label>
                                                <div class="addfiles form-control" data="#aadhar_card_backend_file" id="aadhar_card_backend_file_label"><span class="file_label">Choose
                                                        Aadhar Card Back </span></div>
                                                <input type="file" accept="image/png, image/gif, image/jpeg" style="display:none;" placeholder="Aadhar Card Backend" name="aadhar_card_backend_file" id="aadhar_card_backend_file" class="onboard-form form-control files" required/>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6 mb-2">
                                                <!-- <label class="" for="pan_card">Pan Card{!! required() !!}</label> -->
                                                <label for="" class="float-label"> Pan
                                                    Card<span class="text-danger">*</span></label>
                                                <div class="addfiles form-control" data="#pan_card_file" id="pan_card_file_label"><span class="file_label">Upload Pan
                                                        Card</span></div>
                                                <input type="file" accept="image/png, image/gif, image/jpeg" style="display:none;" placeholder="Pan Card" name="pan_card_file" id="pan_card_file" class="onboard-form form-control files" required/>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6 mb-2">
                                                <!-- <label class="" for="passport">Passport{!! required() !!}</label> -->
                                                <label for="" class="float-label">
                                                    Passport</label>
                                                <div class="addfiles form-control" data="#passport_file" id="passport_file_label"><span class="file_label">Choose
                                                        Passport</span></div>
                                                <input type="file" accept="image/png, image/gif, image/jpeg" style="display:none;" placeholder="Passport" name="passport_file" id="passport_file" class="onboard-form form-control files" required/>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6 mb-2">
                                                <!-- <label class="" for="voters_id">Voters ID</label> -->
                                                <label for="" class="float-label">
                                                    Voters
                                                    ID</label>
                                                <div class="addfiles form-control" data="#voters_id_file" id="voters_id_file_label"><span class="file_label">Choose Voters
                                                        ID</span></div>
                                                <input type="file" accept="image/png, image/gif, image/jpeg" style="display:none;" placeholder="Voters ID" name="voters_id_file" id="voters_id_file" class="onboard-form form-control files" required/>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6 mb-2">
                                                <!-- <label class="" for="dl_file">Driving License</label> -->
                                                <label for="" class="float-label"> Driving License</label>
                                                <div class="addfiles form-control" data="#dl_file" id="dl_file_label"><span class="file_label">Choose Driving
                                                        License</span></div>
                                                <input type="file" accept="image/png, image/gif, image/jpeg" style="display:none;" placeholder="Driving License" name="dl_file" id="dl_file" class="onboard-form form-control files" required/>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
                                                <!-- <label class="" for="education_certificate">Educations Certificate{!! required() !!}</label> -->
                                                <label for="" class="float-label">Educations Certificate<span class="text-danger">*</span></label>
                                                <div class="addfiles form-control" data="#education_certificate_file" id="education_certificate_file_label"><span class="file_label">Choose
                                                        Educations Certificate</span></div>
                                                <input type="file" accept="image/png, image/gif, image/jpeg" style="display:none;" placeholder="Educations Certificate" name="education_certificate_file" id="education_certificate_file" class="onboard-form form-control files" required/>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
                                                <!-- <label class="" for="reliving_letter">Reliving Letter</label> -->
                                                <label for="" class="float-label"> Relieving Letter</label>
                                                <div class="addfiles form-control" data="#reliving_letter_file" id="reliving_letter_file_label"><span class="file_label">Choose
                                                        Relieving Letter</span></div>
                                                <input type="file" accept="image/png, image/gif, image/jpeg" style="display:none;" placeholder="Relieving Letter" name="reliving_letter_file" id="reliving_letter_file" class="onboard-form form-control files" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 text-right"><button type="button" data="row-6" next="row-6" placeholder="" name="next" id="submit_button" class="btn btn-orange  text-center" value="Submit">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--Main Content-->
</div>

<!-- Vertically Centered -->
<div class="modal fade" id="notificationModal" role="dialog" aria-hidden="true" style="opacity:1; display:none;background:#00000073;">
    <div class="modal-dialog modal-md modal-dialog-centered" id="" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2">
        <div class="modal-content">
            <div class="modal-header py-2 bg-primary">

                <div class="w-100 modal-header-content d-flex align-items-center py-2">
                    <h5 class="modal-title text-white" id="modalHeader">Failure
                    </h5>
                    <button type="button" class="btn-close btn-close-white close-modal" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="mt-4">
                    <h6 class="mb-3" id="modalSubHeading">---</h6>
                    <p class="text-muted mb-4" id="modalBody"></p>
                    <div class="hstack gap-2 justify-content-center">
                        <button type="button" id="button_close" class="btn btn-light close-modal" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- @endsection --}}
